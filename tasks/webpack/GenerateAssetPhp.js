import fs from 'fs';
import path from 'path';
import crypto from 'crypto';

class GenerateAssetPhp {
	constructor() {
		this.startTime = Date.now();
		this.prevTimestamps = new Map();
	}
	apply(compiler) {
		compiler.hooks.emit.tapAsync('GenerateAssetPhp', (compilation, callback) => {
			const assetFiles = Object.keys(compilation.assets);

			let blockAssetsToGenerate = [];
			if ('undefined' === typeof compiler.modifiedFiles) {
				blockAssetsToGenerate = assetFiles.filter((fileName) =>
					fileName.includes('/acf-blocks/')
				);
			} else {
				assetFiles.forEach((fileName) => {
					compiler.modifiedFiles.forEach((modifiedFile) => {
						if ('.json' === path.extname(modifiedFile)) {
							// If block.json file changes, regenerate all assets asset.php files.
							const dirname = path.dirname(modifiedFile);
							if (
								fileName.includes('/acf-blocks/') &&
								dirname.includes(
									path.dirname(
										fileName.replace('./', '/').replace('/dist/js/', '/src/')
									)
								)
							) {
								blockAssetsToGenerate.push(fileName);
							}
						} else if (
							fileName.includes('/acf-blocks/') &&
							modifiedFile.includes(
								fileName.replace('./', '/').replace('/dist/', '/src/')
							)
						) {
							blockAssetsToGenerate.push(fileName);
						}
					});
				});
			}

			this.generateBlockAssetPhpFromFiles(blockAssetsToGenerate);

			callback();
		});
	}

	generateBlockAssetPhpFromFiles(fileNames) {
		fileNames.forEach((fileName) => {
			const blockMatches = fileName.match(/\/acf-blocks\/([a-z0-9-]+)\//i);
			const jsonFile = `.${blockMatches[0]}/src/block.json`;
			if (null !== blockMatches && fs.existsSync(jsonFile)) {
				const blockJson = JSON.parse(fs.readFileSync(jsonFile));

				const fileNameNoExt = path.basename(fileName, path.extname(fileName));

				const assetVersion = crypto.randomUUID().replace('-', '');
				let assetDeps = [];

				if ('undefined' !== typeof blockJson[fileNameNoExt]) {
					const wpDefinedAsset = blockJson[fileNameNoExt];

					if (wpDefinedAsset instanceof Array) {
						assetDeps = wpDefinedAsset.filter(dep => !dep.includes('file:'));
					} else if (typeof wpDefinedAsset === 'string' && !wpDefinedAsset.includes('file:')) {
						assetDeps = [wpDefinedAsset];
					}

					const assetPhp = `<?php return array('dependencies' => ${JSON.stringify(
						assetDeps
					)}, 'version' => '${assetVersion}');`;

					fs.mkdirSync(`.${blockMatches[0]}dist/js`, { recursive: true });
					fs.writeFileSync(
						`.${blockMatches[0]}dist/js/${fileNameNoExt}.asset.php`,
						assetPhp
					);
				}
			}
		});
	}
}

export default GenerateAssetPhp;
