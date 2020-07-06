# Korbeil's dotfiles

## Repository

This repository is configured to work with `chezmoi` tool, so first of all, you need: https://github.com/twpayne/chezmoi to make it works.

## Softwares

```
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
curl -sfL https://git.io/chezmoi | sh

sudo apt-get update
sudo apt install vim git curl ruby python-pip npm yarn tmux docker.io python3-dev python3-pip python3-setuptools
pip install pipenv
sudo pip3 install thefuck
sudo gem install tmuxinator

sudo usermod -a -G docker $USER

sudo wget https://github.com/bcicen/ctop/releases/download/v0.7.2/ctop-0.7.2-linux-amd64 -O /usr/local/bin/ctop
sudo chmod +x /usr/local/bin/ctop
```

## Manual installations

- [lsd](https://github.com/Peltoche/lsd)

## Gnome extensions 

- [Emoji Selector](https://extensions.gnome.org/extension/1162/emoji-selector/)
- [GTK Title Bar](https://extensions.gnome.org/extension/1732/gtk-title-bar/)
- [Screenshot tool](https://extensions.gnome.org/extension/1112/screenshot-tool/)
- [Switcher](https://extensions.gnome.org/extension/973/switcher/)
- [Remove ALT-Tab delay](https://extensions.gnome.org/extension/1403/remove-alttab-delay/)

