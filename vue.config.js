fs = require('fs');
module.exports = {
  publicPath: '/registration/',
  devServer: {
    host: '0.0.0.0',
    port: 8092,
    headers: {
      'Access-Control-Allow-Origin': 'https://10.10.200.225:8092',
    },
    disableHostCheck: true,
    public: 'www.northriverboats.com:8092',
    https: {
      key: fs.readFileSync("./certs/localhost-key.pem"),
      cert: fs.readFileSync("./certs/localhost.pem")
    },
  }
}
