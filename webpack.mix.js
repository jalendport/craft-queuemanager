let mix = require('laravel-mix')
require('laravel-mix-purgecss')

// Custom PurgeCSS extractor for Tailwind that allows special characters in class names.
class TailwindExtractor {
  static extract(content) {
    return content.match(/[A-z0-9-:\/]+/g) || [];
  }
}

mix.js('src/assetbundles/src/vendor.js', 'src/assetbundles/dist/bundle.js')
  .sass('src/assetbundles/src/styles.scss', 'src/assetbundles/dist/styles.css')
  .options({
    processCssUrls: false,
    postCss: [ require('tailwindcss')('tailwind.js') ],
  })
  .purgeCss({
    globs: [
      path.join(__dirname, 'src/templates/**/*.{html,twig}'),
    ],
    extractor: TailwindExtractor,
    extensions: ['html', 'twig', 'js', 'css', 'scss'],
    whitelistPatterns: [],
  });
