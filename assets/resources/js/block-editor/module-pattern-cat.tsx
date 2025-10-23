const { registerPlugin } = wp.plugins;
import ModulePatternSidebar from './ModulePatternSidebar';

registerPlugin('module-pattern-sidebar', {
	render() {
		return <ModulePatternSidebar />;
	},
});
