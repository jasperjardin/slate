const videoLightboxes = document.querySelectorAll<HTMLElement>(
	'.video-control[data-micromodal-trigger]'
);

window.MicroModal.init({ awaitOpenAnimation: true, awaitCloseAnimation: true });
if (videoLightboxes) {
	videoLightboxes.forEach((lightbox) => {
		lightbox.addEventListener('click', (e) => {
			e.preventDefault();
			if (lightbox.dataset.micromodalTrigger) {
				const iframe = document
					.getElementById(lightbox.dataset.micromodalTrigger)
					?.querySelector('iframe');

				if (iframe) {
					const videoSrc = iframe.getAttribute('data-src');

					if (videoSrc) {
						window.MicroModal.show(lightbox.dataset.micromodalTrigger, {
							awaitOpenAnimation: true,
							awaitCloseAnimation: true,
							disableScroll: true,
							onShow: () => {
								iframe.src = videoSrc;

								// Disable all no autoplay videos.
								document
									.querySelectorAll('.video-inline--no-autoplay')
									.forEach((container) => {
										const noAutoplayIframe =
											container.querySelector<HTMLIFrameElement>('iframe');

										if (noAutoplayIframe) {
											noAutoplayIframe.src = '';
											noAutoplayIframe.classList.remove('visible');
										}
									});
							},
							onClose: () => {
								iframe.src = '';
							},
						});
					}
				}
			}
		});
	});
}
