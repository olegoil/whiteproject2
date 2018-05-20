const should = require('chai')
    .use(require('chai-as-promised'))
    .should()

const EVMThrow = 'revert'

module.exports = { should, EVMThrow }