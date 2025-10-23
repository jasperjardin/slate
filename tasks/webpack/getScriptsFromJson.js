import fs from 'fs';
import path from 'path';
import glob from 'glob';

const getScriptsFromJson = (globString) => {
	const blockJsFiles = [];
	const blockConfigFiles = glob.sync(globString);
	blockConfigFiles.forEach((configFilename) => {
		const blockJson = JSON.parse(fs.readFileSync(configFilename));

		const scriptJs = getScriptFromBlockJson(blockJson.script, configFilename);
		if (scriptJs) {
			blockJsFiles.push([scriptJs, configFilename]);
		}

		const editorJs = getScriptFromBlockJson(blockJson.editorScript, configFilename);
		if (editorJs) {
			blockJsFiles.push([editorJs, configFilename]);
		}

		const viewJs = getScriptFromBlockJson(blockJson.viewScript, configFilename);
		if (viewJs) {
			blockJsFiles.push([viewJs, configFilename]);
		}
	});

	return blockJsFiles;
};

const getScriptFromBlockJson = (script, configFilename) => {
	if (!script) {
		return false;
	}

	let scriptFile = '';
	if (script instanceof Array) {
		scriptFile = script.find(item => item.includes('file:')) || script[0];
	} else {
		scriptFile = script;
	}

	if (!scriptFile.includes('file:')) {
		return false;
	}

	scriptFile = scriptFile.replace('file:', '').replace('./', '');

	const configPath = path.dirname(configFilename);
	return configPath + '/' + scriptFile;
};

export default getScriptsFromJson;
