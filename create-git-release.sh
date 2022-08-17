#!/bin/bash

read -p "Which version is this release? " version
git checkout develop
git checkout -b release-${version} develop

read -p "Do you want to release this version? (y/n) " yn
case ${yn} in
  y ) ;;
  * ) exit;;
esac

read -p "Is this an npm package? (y/n) " yn

case ${yn} in
  y )
    read -p "Which version type? (major/minor/patch) " type;
    case ${type} in
      major ) npm version major;;
      minor ) npm version minor;;
      patch ) npm version patch;;
      * )
        echo "Type undefined.";
        exit;;
    esac;;
  * ) git tag v${version};;
esac

git checkout master
git merge --no-ff release-${version} -m "Merge release-${version}"
git checkout develop
git merge --no-ff release-${version} -m "Merge release-${version}"
git branch -d release-${version}
git push origin develop
git push origin master
git push origin v${version}




