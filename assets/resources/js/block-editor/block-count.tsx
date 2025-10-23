// eslint-disable @typescript-eslint/no-explicit-any
const {
	blockEditor: { store: blockEditorStore },
	compose: { createHigherOrderComponent },
	element: { createElement: el, useEffect },
	data: { useSelect },
	hooks: { addFilter },
	blocks: { getBlockSupport },
} = wp;

interface BlockEditProps {
	clientId: string;
	attributes: {
		className?: string;
		errorMessage?: string;
	};
	name: string;
	setAttributes: (attributes: object) => void;
}

interface BlockProps {
	innerBlocks: BlockProps[];
	clientId: string;
	name: string;
	attributes: {
		className?: string;
		errorMessage?: string;
	};
}

class BlockCounter {
	delay: number;
	debouncedTraverseBlocks: (blocks: BlockProps[]) => void;

	constructor() {
		this.delay = 200;
		this.debouncedTraverseBlocks = this.debounce(this.traverseBlocks.bind(this), this.delay);

		// Subscribe to block changes for real-time updates
		wp.data.subscribe(() => {
			const blockEditor = wp.data.select('core/block-editor');
			const rootBlocks = blockEditor.getBlocks(); // Get all root-level blocks

			this.debouncedTraverseBlocks(rootBlocks);
		});
	}

	traverseBlocks(blocks: BlockProps[] = []) {
		blocks.forEach((block) => {
			this.checkAndApplyAppenderClass(block.clientId);
			if (block.innerBlocks?.length) {
				this.traverseBlocks(block.innerBlocks);
			}
		});
	}

	debounce<T>(func: (arg: T) => void, wait: number): (arg: T) => void {
		let timeout: ReturnType<typeof setTimeout> | null;

		return (arg: T) => {
			if (timeout) clearTimeout(timeout);
			timeout = setTimeout(() => {
				func(arg);
			}, wait);
		};
	}

	/**
	 * Updates the class to hide or show the appender.
	 *
	 * @param clientId
	 * @param shouldHide
	 */
	updateBlockClass(clientId: string, shouldHide: boolean) {
		const blockEditor = wp.data.select('core/block-editor');
		const block = blockEditor.getBlock(clientId);
		if (!block) return;

		const currentClass = block.attributes?.className || '';
		const hasClass = currentClass.includes('hide-appender');

		if (shouldHide && !hasClass) {
			wp.data.dispatch('core/block-editor').updateBlockAttributes(clientId, {
				className: `${currentClass} hide-appender`.trim(),
			});
		} else if (!shouldHide && hasClass) {
			wp.data.dispatch('core/block-editor').updateBlockAttributes(clientId, {
				className: currentClass.replace('hide-appender', '').trim(),
			});
		}
	}

	/**
	 * Adds an error notice when limits are exceeded and prevents duplicates.
	 *
	 * @param clientId
	 * @param message
	 */
	handleError(clientId: string, message: string) {
		const blockEditor = wp.data.select('core/block-editor');
		const parentBlock = blockEditor.getBlock(clientId);
		if (!parentBlock) return;

		const parentBlockName = wp.blocks.getBlockType(parentBlock.name)?.title || parentBlock.name;
		const fullMessage = `${parentBlockName}: ${message}`;

		const noticeId = `block-limit-error-${clientId}`;

		// Remove existing notice before adding a new one.
		wp.data.dispatch('core/notices').removeNotice(noticeId);
		wp.data.dispatch('core/notices').createNotice('error', fullMessage, {
			id: noticeId,
			isDismissible: true,
		});
	}

	/**
	 * Removes a block when its limit is exceeded.
	 *
	 * @param clientId
	 * @param errorMessage
	 */
	deleteBlock(clientId: string, errorMessage: string) {
		const parentBlockId = wp.data.select('core/block-editor').getBlockParents(clientId);
		const parentBlockClientId = parentBlockId[parentBlockId.length - 1];

		wp.data.dispatch('core/block-editor').removeBlock(clientId);
		this.handleError(parentBlockClientId, errorMessage);
	}

	/**
	 * Validates the block limits and hides appender if necessary.
	 *
	 * @param parentClientId
	 */
	checkAndApplyAppenderClass(parentClientId: string) {
		const blockEditor = wp.data.select('core/block-editor');
		const parentBlock = blockEditor.getBlock(parentClientId);
		if (!parentBlock) return;

		const limit = getBlockSupport(parentBlock.name, 'innerBlockLimit');
		if (!limit) return;

		let shouldHide = false;
		let errorMessage = '';
		if (typeof limit === 'number') {
			if (parentBlock.innerBlocks.length >= limit) {
				shouldHide = true;
				errorMessage = `You can only add up to ${limit} blocks.`;
			}

			if (parentBlock.innerBlocks.length > limit) {
				this.deleteBlock(
					parentBlock.innerBlocks[parentBlock.innerBlocks.length - 1].clientId,
					errorMessage
				);
			}
		} else if (typeof limit === 'object') {
			if (limit.total && typeof limit.total === 'number') {
				if (parentBlock.innerBlocks.length >= limit.total) {
					shouldHide = true;
					errorMessage = `You can only add up to ${limit.total} blocks.`;
				}
			}

			if (limit.blocks && typeof limit.blocks === 'object') {
				Object.keys(limit.blocks).forEach((blockName) => {
					const blockLimit = limit.blocks[blockName];
					const matchingBlocks = parentBlock.innerBlocks.filter(
						(b: BlockProps) => b.name === blockName
					);

					if (matchingBlocks.length > blockLimit) {
						this.deleteBlock(
							matchingBlocks[matchingBlocks.length - 1].clientId,
							`You can only add up to ${blockLimit} ${blockName
								.replace('core/', '')
								.replace('acf/', '')} blocks.`
						);
					}

					// Hide appender only if ALL blocks have met their limits
					shouldHide = Object.keys(limit.blocks).every((name) => {
						const count = parentBlock.innerBlocks.filter(
							(b: BlockProps) => b.name === name
						).length;
						return count >= limit.blocks[name];
					});
				});
			}
		}

		this.updateBlockClass(parentClientId, shouldHide);
	}

	onBlockAdded = (block: BlockProps) => {
		const blockEditor = wp.data.select('core/block-editor');
		const parentBlockId = blockEditor.getBlockParents(block.clientId);
		const parentBlockClientId = parentBlockId[parentBlockId.length - 1]; // Get the closest parent block ID

		if (parentBlockClientId) {
			this.checkAndApplyAppenderClass(parentBlockClientId);
		}
	};

	addedBlocks = new WeakSet();

	addWithInnerBlocks = (block: BlockProps) => {
		this.onBlockAdded(block);
		this.addedBlocks.add(block);
		for (const innerBlock of block.innerBlocks) {
			this.addWithInnerBlocks(innerBlock);
		}
	};

	blockCounter = createHigherOrderComponent(
		(BlockEdit: React.ComponentType<BlockEditProps>) => (props: BlockEditProps) => {
			const { getBlock, wasBlockJustInserted, getBlocks } = useSelect(blockEditorStore);

			useEffect(() => {
				const { clientId } = props;
				const self = getBlock(clientId);
				const blocks = getBlocks();

				blocks.forEach((block: BlockProps) => {
					this.addWithInnerBlocks(block);
				});

				if (wasBlockJustInserted(clientId)) {
					this.addedBlocks.has(self);
					this.addWithInnerBlocks(self);
				}

				// Ensure appender visibility updates on render
				const parentBlockId = getBlock(clientId)?.parentId;
				if (parentBlockId) {
					this.checkAndApplyAppenderClass(parentBlockId);
				}
			}, []); // eslint-disable-line react-hooks/exhaustive-deps

			return el(BlockEdit, props);
		},
		'block-counter'
	);

	init() {
		addFilter('editor.BlockEdit', 'impulse/custom-block-counter', this.blockCounter);
	}
}

export default new BlockCounter();
