import * as React from 'react';

interface Props {
	isLoading: boolean;
	children: React.ReactNode;
	height: number | null;
	firstRun: boolean;
}

const Loading = ({ isLoading, children, height }: Props) => {
	if (isLoading) {
		const heightStyle = null !== height ? height : undefined;
		return (
			<div className="pfa-loading" style={{ height: heightStyle }}>
				<div className="pfa-loading__spinner" />
			</div>
		);
	}
	return <>{children}</>;
};

Loading.displayName = 'Loading';

export default Loading;
