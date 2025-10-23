document.querySelectorAll<HTMLElement>('.logo-slider').forEach((slider) => {
	const wrapper = slider.querySelector<HTMLElement>('.logo-slider__wrapper');
	const nextButton = slider.querySelector<HTMLElement>('.logo-slider__button--next');
	const prevButton = slider.querySelector<HTMLElement>('.logo-slider__button--prev');

	if (!wrapper || !nextButton || !prevButton) return;

	const slideCount = wrapper.querySelectorAll('.swiper-slide').length;

	const updateNavigationVisibility = (swiper: typeof window.Swiper): void => {
		const isNavigationHidden = slideCount <= swiper.loopedSlides;

		wrapper.parentElement?.classList.toggle('swiper-no-arrows', isNavigationHidden);
	};

	new (window as Window).Swiper(wrapper, {
		slidesPerView: 2,
		spaceBetween: 32,
		loop: true,
		centerInsufficientSlides: true,
		navigation: {
			nextEl: nextButton,
			prevEl: prevButton,
		},
		breakpoints: {
			576: {
				slidesPerView: 3,
				spaceBetween: 32,
			},
			768: {
				slidesPerView: 4,
				spaceBetween: 40,
			},
			992: {
				slidesPerView: 6,
				spaceBetween: 40,
			},
		},
		on: {
			init(swiper: typeof window.Swiper) {
				updateNavigationVisibility(swiper);
			},
			breakpoint(swiper: typeof window.Swiper) {
				updateNavigationVisibility(swiper);
			},
		},
	});
});
