const sliders = document.querySelectorAll<HTMLElement>('.post-slider');

sliders.forEach((slider) => {
	new (window as Window).Swiper(slider, {
		slidesPerView: 1.1,
		spaceBetween: 16,
		breakpoints: {
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
		},
		navigation: {
			nextEl: '.slider-pagination__button--next',
			prevEl: '.slider-pagination__button--prev',
			disabledClass: 'slider-pagination__button--disabled',
		},
	});
});
