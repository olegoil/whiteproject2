var Whitecoin = artifacts.require("./Whitecoin.sol");
const { should, EVMThrow } = require('./helpers');

contract('Whitecoin', function(accounts) {

    let whitecoin;
    let manager = accounts[0];

    beforeEach('setup contract for each test', async function() {
        whitecoin = await Whitecoin.new();
    })

    it('has a manager', async function() {
        assert.equal(await whitecoin.isManager(manager), true)    
    })

    it('only one manager after creation', async function() {
        assert.equal(await whitecoin.isManager(accounts[1]), false)    
    })

    it('manager can add minter', async function() {
        await whitecoin.addMinter(accounts[1]);
        assert.equal(await whitecoin.isMinter(accounts[1]), true)
    })

    it('minter can accept mint request', async function() {
        let amount = 300000;
        let address = accounts[2];
        await whitecoin.addMinter(manager);
        await whitecoin.mintingRequest(amount, address);
    })

    it('manager can accept mint request', async function() {
        let amount = 30000;
        let address = accounts[2];
        await whitecoin.addMinter(manager);
        await whitecoin.mintingRequest(amount, address);
        await whitecoin.mintWhitecoin(1, 1);
        assert.equal(await whitecoin.balanceOf(address), amount);
    })

    it('Should be rejected while non-manager adds minter', async function() {
        whitecoin.addMinter(accounts[2], {from: accounts[2]}).should.be.rejectedWith(EVMThrow);
    })

    it('Frozen accounts can\'t transfer tokens', async function() {
        await whitecoin.addMinter(manager);
        await whitecoin.transfer(accounts[1], 10000000);
        await whitecoin.freezeAccount(accounts[1]);
        await whitecoin.transfer(accounts[1], 10000000, {from: accounts[1]}).should.be.rejectedWith(EVMThrow);
    })
});
