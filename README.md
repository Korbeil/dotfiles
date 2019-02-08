# Korbeil's dotfiles

## Repository

This repository is configured to work with `chezmoi` tool, so first of all, you need: https://github.com/twpayne/chezmoi to make it works.

## Softwares

```
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list

sudo apt-get update
sudo apt install vim git curl ruby python-pip npm yarn chezmoi tmux docker.io thefuck
pip install pipenv
sudo gem install tmuxinator
```
