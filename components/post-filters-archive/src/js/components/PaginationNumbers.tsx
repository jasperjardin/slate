import * as React from 'react';

interface IProps {
	page: number;
	maxNumPages: number;
	setPage?: (page: number) => void;
}

const Pagination = ({ page, maxNumPages, setPage }: IProps) => {
	const handlePageClick = (e: React.MouseEvent, pageNum: number) => {
		e.preventDefault();
		if (setPage) {
			const newPage = Math.max(1, Math.min(pageNum, maxNumPages));
			setPage(newPage);
		}
	};

	const range = (start: number, end: number) => {
		return Array.from({ length: end - start }, (_, i) => i + start);
	};

	const paginationNumbers = (siblings = 1) => {
		const totalPageNo = 7 + siblings;

		if (totalPageNo >= maxNumPages) {
			return range(1, maxNumPages + 1);
		}

		const leftSiblingsIndex = Math.max(page - siblings, 1);
		const rightSiblingsIndex = Math.min(page + siblings, maxNumPages);

		const showLeftDots = leftSiblingsIndex > 2;
		const showRightDots = rightSiblingsIndex < maxNumPages - 2;

		if (!showLeftDots && showRightDots) {
			const leftItemsCount = 3 + 2 * siblings;
			const leftRange = range(1, leftItemsCount + 1);
			return [...leftRange, 'rightDot', maxNumPages];
		} else if (showLeftDots && !showRightDots) {
			const rightItemsCount = 3 + 2 * siblings;
			const rightRange = range(maxNumPages - rightItemsCount + 1, maxNumPages + 1);
			return [1, 'leftDot', ...rightRange];
		}
		const middleRange = range(leftSiblingsIndex, rightSiblingsIndex + 1);
		return [1, 'leftDot', ...middleRange, 'rightDot', maxNumPages];
	};

	const pageNumbers = paginationNumbers();

	const baseUrl = new URL(window.location.href).pathname.replace(/\/page\/\d+/, '');

	const getPageHref = (pageNum: number) => {
		if (pageNum > 1) {
			return `${baseUrl}page/${pageNum}`;
		}
	};

	if (maxNumPages > 1) {
		return (
			<nav className="pfa-pagination" aria-label="pagination">
				<div className="pfa-pagination__prev-buttons">
					<a
						className={`pfa-pagination__prev ${page > 1 ? '' : 'pfa-pagination__prev--disabled'}`}
						onClick={(e) => handlePageClick(e, 1)}
						aria-label="Go to first page"
						href={getPageHref(1)}
					>
						<span className="icon-double-arrow-left"></span>
					</a>
					<a
						className={`pfa-pagination__prev ${page > 1 ? '' : 'pfa-pagination__prev--disabled'}`}
						onClick={(e) => handlePageClick(e, page - 1)}
						aria-label="Go to previous page"
						href={getPageHref(page - 1)}
						rel={page - 1 > 1 ? 'canonical' : undefined}
					>
						<span className="icon-chevron-left"></span>
					</a>
				</div>
				<div className="pfa-pagination__page-numbers">
					{pageNumbers.map((value, index) => {
						if (value === 'leftDot') {
							return (
								<a
									key={index}
									className="pfa-pagination__page-number"
									onClick={(e) => handlePageClick(e, page - 5)}
									aria-label="Go back 5 pages"
									href={getPageHref(page - 5)}
									rel={page - 5 > 1 ? 'canonical' : undefined}
								>
									...
								</a>
							);
						} else if (value === 'rightDot') {
							return (
								<a
									key={index}
									className="pfa-pagination__page-number"
									onClick={(e) => handlePageClick(e, page + 5)}
									aria-label="Go forward 5 pages"
									href={getPageHref(page + 5)}
									rel={page + 5 > 1 ? 'canonical' : undefined}
								>
									...
								</a>
							);
						} else if (value === page) {
							return (
								<a
									key={index}
									className={`pfa-pagination__page-number pfa-pagination__page-number--active`}
									onClick={(e) => handlePageClick(e, Number(value))}
									aria-label={`Current page, page ${value}`}
									aria-current="page"
									href={getPageHref(Number(value))}
									rel={Number(value) > 1 ? 'canonical' : undefined}
								>
									{value}
								</a>
							);
						}
						return (
							<a
								key={index}
								className="pfa-pagination__page-number"
								onClick={(e) => handlePageClick(e, Number(value))}
								aria-label={`Go to page ${value}`}
								href={getPageHref(Number(value))}
								rel={Number(value) > 1 ? 'canonical' : undefined}
							>
								{value}
							</a>
						);
					})}
				</div>
				<div className="pfa-pagination__next-buttons">
					<a
						className={`pfa-pagination__next ${page < maxNumPages ? '' : 'pfa-pagination__next--disabled'}`}
						onClick={(e) => handlePageClick(e, page + 1)}
						aria-label="Go to next page"
						rel="canonical"
						href={getPageHref(page + 1)}
					>
						<span className="icon-chevron-right"></span>
					</a>
					<a
						className={`pfa-pagination__next ${page < maxNumPages ? '' : 'pfa-pagination__next--disabled'}`}
						onClick={(e) => handlePageClick(e, maxNumPages)}
						aria-label="Go to last page"
						rel="canonical"
						href={getPageHref(maxNumPages)}
					>
						<span className="icon-double-arrow-right"></span>
					</a>
				</div>
			</nav>
		);
	}
	return null;
};

Pagination.displayName = 'LoadMore';

export default Pagination;
