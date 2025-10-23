// $element is JQuery which we don't use
// eslint-disable-next-line @typescript-eslint/no-explicit-any
window.acf.addAction('render_block_preview', function ($element: any) {
	const $links = $element.find('a');

	// Disable link clicks inside of a block.
	$links.on('click', function (event: MouseEvent) {
		event.preventDefault();
	});

	// Change cursor style to default
	$links.css('cursor', 'inherit');
});
