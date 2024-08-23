const srcFolder = "./src";
const buildFolder = "../assets/app";
const siteUrl = "http://shop/";

export const paths = {
  base: {
    src: srcFolder,
    build: buildFolder,
    url: siteUrl,
  },
  srcSvg: `${srcFolder}/img/svg/**.svg`,
  srcImgFolder: `${srcFolder}/img`,
  buildImgFolder: `${buildFolder}/img`,
  srcScss: `${srcFolder}/scss/**/*.scss`,
  buildCssFolder: `${buildFolder}/css`,
  srcFullJs: `${srcFolder}/js/**/*.js`,
  srcMainJs: `${srcFolder}/js/main.js`,
  buildJsFolder: `${buildFolder}/js`,
  resourcesFolder: `${srcFolder}/resources`,
};
