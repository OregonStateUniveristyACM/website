# Website
This is the github page for Oregon State University ACM's new website

# Development
## Set Up
### Downloading
If you are missing npm, yarn or both, following [this link](https://yarnpkg.com/en/docs/install) will give you the steps to install whatever you need.

Make sure you have all the required components installed by checking the version number of both npm and yarn:
* `npm -v`
* `yarn --version`

If everything installed properly, `yarn install` will download all the code needed to build and run the site locally

### Building with Gulp

This project is using the newest version of gulp: [gulp v4](https://fettblog.eu/gulp-4-parallel-and-series/)

To see all the tasks specified in the gulp file you can run `gulp --tasks`  
The most important tasks are:
* `gulp` <- this builds the destination folder and serves it up in chrome
* `gulp clean` <- deletes the destination folder for a clean start
* `gulp build` <- builds the destination folder
* `gulp serve` <- serves the destination folder in google chrome
