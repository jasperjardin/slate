import gulp from 'gulp';
import { readFileSync, writeFileSync } from 'fs';
import { join } from 'path';
import glob from 'glob';

// Target files that should contain CSS variable definitions
const CSS_VARIABLE_FILES = [
	'./assets/resources/css/helpers/_variables.scss',
	'./assets/resources/css/main/globals/*.scss'
];

/**
 * CSS Variables Generator Task
 *
 * Generates custom-properties.json file for stylelint plugin from theme variables.
 */
class CSSVariables {
	constructor() {
		this.validVariables = new Set();
		this.rootPath = process.cwd();
		this.variableFiles = CSS_VARIABLE_FILES.map(file => file.replace('./', ''));
	}

	/**
	 * Extract CSS variables from target files
	 */
	extractCSSVariables(silent = false) {
		if (!silent) console.log('Extracting CSS variables from theme files...');

		// Get all target files
		const files = [];
		this.variableFiles.forEach(pattern => {
			const matches = glob.sync(pattern, {
				cwd: this.rootPath,
				absolute: true
			});
			files.push(...matches);
		});

		files.forEach(filePath => {
			try {
				const content = readFileSync(filePath, 'utf8');
				if (!silent) console.log(`Processing: ${filePath}`);

				this.extractFromPaintsMap(content);
				this.extractFromRootBlocks(content);
				this.extractWPPresetVariables(content);
			} catch (error) {
				if (!silent) console.error(`Could not read file: ${filePath}`);
			}
		});

		if (!silent) console.log(`Found ${this.validVariables.size} CSS variables`);
	}

	/**
	 * Extract variables from $paints map
	 */
	extractFromPaintsMap(content) {
		const paintsMatch = content.match(/\$paints:\s*\(([\s\S]*?)\);/);
		if (paintsMatch) {
			const paintsContent = paintsMatch[1];
			const variableMatches = paintsContent.match(/"([^"]+)":/g);

			if (variableMatches) {
				variableMatches.forEach(match => {
					const varName = match.replace(/"/g, '').replace(':', '');
					this.validVariables.add(`--${varName}`);
				});
			}
		}
	}

	/**
	 * Extract variables from :root blocks
	 */
	extractFromRootBlocks(content) {
		const rootVarPattern = /--([a-zA-Z0-9-_]+)\s*:/g;
		let match;
		while ((match = rootVarPattern.exec(content)) !== null) {
			this.validVariables.add(`--${match[1]}`);
		}
	}

	/**
	 * Extract WordPress preset variables
	 */
	extractWPPresetVariables(content) {
		const wpPresetPattern = /--wp--preset--[a-zA-Z0-9-_]+/g;
		let match;
		while ((match = wpPresetPattern.exec(content)) !== null) {
			this.validVariables.add(match[0]);
		}
	}

	/**
	 * Generate custom-properties.json for stylelint plugin
	 */
	generator() {
		this.extractCSSVariables(true);

		const customPropertiesObj = {};

		// Add all valid variables as syntax references for stylelint using <any-value> as a placeholder
		this.validVariables.forEach(variable => {
			customPropertiesObj[variable] = '<any-value>';
		});

		const config = {
			"custom-properties": customPropertiesObj
		};

		const outputPath = join(this.rootPath, 'css-variables.json');
		const jsonContent = JSON.stringify(config, null, 2);

		writeFileSync(outputPath, jsonContent);

		return config;
	}
}

gulp.task('css-vars', (done) => {
	const generator = new CSSVariables();
	generator.generator();
	done();
});

gulp.task('css-vars:watch', (done) => {
	gulp.watch(CSS_VARIABLE_FILES, gulp.series('css-vars'));
	done();
});
