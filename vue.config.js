module.exports = {
  transpileDependencies: ["vuetify"],
  devServer: {
    proxy: {
      "^/api/vault/core": {
        target: "http://192.168.4.79:20000",
        pathRewrite: {
          "^/api/vault/core": "/api/vault/core",
        },
      },
      "^/api": {
        target: "http://192.168.4.79:80",
        pathRewrite: {
          "^/api": "/api",
        },
      },
    },
  },
};
