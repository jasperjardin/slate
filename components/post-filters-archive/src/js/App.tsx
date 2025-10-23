import * as React from 'react';
import LayoutDefault from './components/layouts/Default';
import { SettingsContext } from './contexts/settings';
import { IAppSettings } from './types';
import LayoutSearch from './components/layouts/Search';

interface IProps {
	settings: IAppSettings;
}

const App = ({ settings }: IProps) => {
	window.dataLayer = window.dataLayer || [];

	// eslint-disable-next-line @typescript-eslint/no-unused-vars
	const renderLayout = (layout: string) => {
		let LayoutOutput = LayoutDefault;
		switch (layout) {
			case 'search': {
				LayoutOutput = LayoutSearch;
				break;
			}

			default: {
				LayoutOutput = LayoutDefault;
				break;
			}
		}

		return <LayoutOutput />;
	};

	return (
		<SettingsContext.Provider value={settings}>
			{renderLayout(settings.layout)}
		</SettingsContext.Provider>
	);
};

App.displayName = 'App';

export default App;
