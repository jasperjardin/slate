const stickyMediaContentSplit = new window.Swiper(
	'.block-sticky-media-content-split .sticky-media-content-split-slider',
	{
		slidesPerView: 1,
		slidesPerGroup: 1,
		spaceBetween: 20,
		allowTouchMove: false,
		effect: 'fade',
		fadeEffect: {
			crossFade: true,
		},
	}
);

const observeSlider = (slider: typeof window.Swiper) => {
	if (slider && slider.el.nodeType) {
		const stickyContentMediaIndex: { [key: string]: number } = {};
		slider.slides.forEach((item: HTMLElement, index: number) => {
			const blockID = item.getAttribute('data-block-id') as string;
			stickyContentMediaIndex[blockID] = index;
		});

		const observerCallback = (entries: Array<IntersectionObserverEntry>) => {
			entries.forEach((entry: IntersectionObserverEntry) => {
				if (entry.isIntersecting) {
					slider.slideTo(stickyContentMediaIndex[entry.target.id]);
				}
			});
		};

		const observer = new IntersectionObserver(observerCallback, {
			rootMargin: '-50% 0px -50% 0px',
			threshold: 0,
		});

		const silderItems: NodeListOf<HTMLElement> | undefined = slider?.el
			?.closest('.block-sticky-media-content-split')
			?.querySelectorAll('.block-media');

		if (silderItems) {
			silderItems.forEach((scroller: HTMLElement) => {
				if (scroller) {
					observer.observe(scroller);

					// Manually trigger the callback if it's already in view
					const rect = scroller.getBoundingClientRect();
					if (rect.top < window.innerHeight && rect.bottom > 0) {
						slider.slideTo(stickyContentMediaIndex[scroller.id]);
					}
				}
			});
		}
	}
};

if (stickyMediaContentSplit) {
	if (Array.isArray(stickyMediaContentSplit)) {
		stickyMediaContentSplit.forEach((slider: typeof window.Swiper) => {
			observeSlider(slider);
		});
	} else {
		observeSlider(stickyMediaContentSplit);
	}
}
