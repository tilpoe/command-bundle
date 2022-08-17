#!/bin/bash

rm -rf .git
git init

if ! [[ -f "README.md" ]]; then
    touch README.md
fi

if ! [[ -f ".gitignore" ]]; then
    touch .gitignore
fi

git add README.md
git commit -m "Singularity"

read -p "Username: " username
read -p "Token: " token
read -p "Repository: " repo

git remote add origin https://${username}:${token}@github.com/${username}/${repo}.git
git push origin master

git checkout -b develop master
git push origin develop

cat <<EOT
Maybe add to .gitignore:
/.idea/
/node_modules/
/vendor/

.DS_Store
._.DS_Store
**/.DS_Store
**/._.DS_Store
EOT

