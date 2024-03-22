/** @type {import('tailwindcss').Config} */
module.exports = {
	content: ['./**/*.{html,js,ts,jsx,tsx,php}'],
	theme: [],
	plugins: [],
	variants: {
		extend: {
			borderColor: ['hover'],
			borderWidth: ['hover'],
			backgroundColor: ['active'],
			textColor: ['active'],
		},
	},
};
