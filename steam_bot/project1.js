const SteamUser = require('steam-user');
const SteamTotp = require('steam-totp');

const client = new SteamUser();

const login_info = require('./config.json');

const logOnOptions = {
  accountName: login_info.username,
  password: login_info.password,
  twoFactorCode: SteamTotp.generateAuthCode(login_info.shared_secret)
};

client.logOn(logOnOptions);

client.on('loggedOn', () => {
  console.log('Logged into Steam');
  
  client.setPersona(SteamUser.EPersonaState.Online);
  client.gamesPlayed(730);
})