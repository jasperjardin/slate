document.querySelectorAll<HTMLElement>('.image-slider').forEach((slider) => {
	const isCarousel = slider.closest('.block-image-slider--carousel') !== null;
	const breakpoints = isCarousel
		? {
				[window.impBreakpoints?.md ?? 768]: {
					slidesPerView: 2.1,
					spaceBetween: 24,
				},
				[window.impBreakpoints?.lg ?? 992]: {
					slidesPerView: 3.1,
				},
				[window.impBreakpoints?.xxl ?? 1304]: {
					slidesPerView: 3,
				},
			}
		: {};

	new window.Swiper(slider, {
		slidesPerView: isCarousel ? 1.1 : 1,
		spaceBetween: 16,
		navigation: {
			nextEl: '.slider-pagination__button--next',
			prevEl: '.slider-pagination__button--prev',
			disabledClass: 'slider-pagination__button--disabled',
		},
		on: {
			slideChange(swiper: typeof window.Swiper) {
				const current = slider.querySelector('.slider-pagination__current') as HTMLElement;
				if (current) {
					current.innerText = (swiper.realIndex + 1).toString();
				}

				slider
					.querySelectorAll<HTMLElement>('.image-slider__caption')
					.forEach((caption) => {
						caption.classList.remove('image-slider__caption--active');
					});
				const nextCaption = slider.querySelector(
					'.image-slider__caption--' + swiper.activeIndex
				) as HTMLElement;
				if (nextCaption) {
					nextCaption.classList.add('image-slider__caption--active');
				}
			},
		},
		breakpoints,
	});
});
