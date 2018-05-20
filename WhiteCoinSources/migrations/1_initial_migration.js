var Migrations = artifacts.require("./Migrations.sol");
var Whitecoin = artifacts.require("./Whitecoin.sol");

module.exports = function(deployer) {
  deployer.deploy(Migrations);
  deployer.deploy(Whitecoin);
};
