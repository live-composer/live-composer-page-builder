module.exports = {
	rootDir: ".",
	moduleNameMapper: {
		"@wordpress/jest-console" : "@wordpress/jest-console",
		// "@wordpress\\/([a-z0-9-]+)$": "<rootDir>/packages/$1/src"
	},
	preset: 'jest-puppeteer',
	setupFilesAfterEnv: [
		// "<rootDir>/setup-test-framework.js"
	],
	testPathIgnorePatterns: [
		"/node_modules/",
		"/packages/"
		// "<rootDir>/.*/build/",
		// "<rootDir>/.*/build-module/"
	],
	transform: {
		"^.+\\.jsx?$": "babel-jest"
	},
	bail: 1,
	verbose: true,
};
