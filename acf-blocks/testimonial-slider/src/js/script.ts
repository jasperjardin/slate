document.querySelectorAll<HTMLElement>('.testimonial-slider').forEach((slider) => {
	const wrapper = slider.querySelector<HTMLElement>('.testimonial-slider__wrapper');

	if (null !== wrapper) {
		new (window as Window).Swiper(wrapper, {
			slidesPerView: 1,
			loop: true,
			navigation: {
				nextEl: slider.querySelector('.testimonial-pagination__button--next'),
				prevEl: slider.querySelector('.testimonial-pagination__button--prev'),
			},
		});
	}
});
