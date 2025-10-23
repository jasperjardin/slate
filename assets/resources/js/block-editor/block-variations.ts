class BlockVariations {
	init() {
		wp.domReady(() => {
			const variationsToUnregister = [
				//'vimeo'
				//'youtube'
				'amazon-kindle',
				'animoto',
				'cloudup',
				'collegehumor',
				'crowdsignal',
				'dailymotion',
				'facebook',
				'flickr',
				'imgur',
				'instagram',
				'issuu',
				'kickstarter',
				'meetup-com',
				'mixcloud',
				'reddit',
				'reverbnation',
				'screencast',
				'scribd',
				'slideshare',
				'smugmug',
				'soundcloud',
				'speaker-deck',
				'spotify',
				'ted',
				'tiktok',
				'tumblr',
				'twitter',
				'videopress',
				'wordpress',
				'wordpress-tv',
				'pinterest',
				'wolfram-cloud',
			];

			for (let i = variationsToUnregister.length - 1; i >= 0; i--) {
				wp.blocks.unregisterBlockVariation('core/embed', variationsToUnregister[i]);
			}

			wp.blocks.unregisterBlockStyle('core/quote', 'default');
			wp.blocks.unregisterBlockStyle('core/quote', 'plain');

			wp.blocks.unregisterBlockStyle('core/image', 'rounded');
			wp.blocks.unregisterBlockStyle('core/image', 'default');

			wp.blocks.registerBlockStyle('core/list', {
				name: 'check',
				label: 'Check',
			});
		});
	}
}

export default new BlockVariations();
