const path = require("path");
const webpack = require("webpack");
const { VueLoaderPlugin } = require("vue-loader");

module.exports = {
  entry: {
    main: "./src/js/index.js",
  },

  output: {
    filename: "[name].js",
    chunkFilename: "[name].js",
    publicPath: "/"
  },

  optimization: {
    splitChunks: {
      cacheGroups: {
        vendor: {
          test: /node_modules/,
          chunks: "initial",
          name: "vendor",
          enforce: true
        }
      }
    }
  },

  module: {
    rules: [
      {
        test: /\.vue$/,
        loader: "vue-loader",
      },
      {
        test: /\.scss$/,
        use: [
          "style-loader",
          "css-loader",
          "sass-loader"
        ]
      }
    ]
  },

  plugins: [
    new webpack.ProvidePlugin({}),
    new VueLoaderPlugin()
  ],

  resolve: {
    alias: {
      "%modules%": path.resolve(__dirname, "src/blocks/modules"),
      "%components%": path.resolve(__dirname, "src/blocks/components")
    }
  }
};
