const playBtns = document.querySelectorAll<HTMLElement>('.video-inline__play');

playBtns.forEach((playBtn) => {
	playBtn.addEventListener('click', () => {
		const media = playBtn.parentElement;
		if (!media) return;

		media.classList.add('component-media--show-video');

		const video = media.querySelector<HTMLElement>('.video-inline');
		if (!video) return;

		video.classList.add('video-inline--is-visible');
		playBtn.style.display = 'none';

		const iframe = video.querySelector<HTMLIFrameElement>('iframe');
		if (iframe) {
			const videoSrc = iframe.getAttribute('data-src');
			if (videoSrc) {
				iframe.src = videoSrc;
				iframe.classList.add('visible');
			}
		}
	});
});
