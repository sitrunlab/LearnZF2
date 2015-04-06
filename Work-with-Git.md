#Work with Git


**Code :**

 _1. Fork repository_

Before start, we need to do fork the repository by click "fork" button in the top right of the repository page.

 _2. PRs_

Always use Pull Request. Steps :

 * Clone to our local computer from forked repository in our account :
```
   git clone https://github.com/samsonasik/LearnZF2.git OurLocalLearnZF2Repository
```
 * Create new branch : for example : 'changelog' :
```
#always start with it to make sure we are from master/develop
git checkout -b changelog master
```
 * Do changes and push to our origin repository :
```
git commit -m "commit message" -a
git push origin changelog
```
 * Keeping up to date for overlapped commits ( do againts master/develop based on your start):
```
git checkout master && git pull upstream master && git checkout changelog && git rebase master
```
 * Do Pull Requests
In our forked repository : _/ouraccount/LearnZF2_ there will be a button "Compare and Create Pull Request", we then could do click :
![1](https://cloud.githubusercontent.com/assets/459648/3942685/5da25e34-2571-11e4-8453-00178259aad3.png)

Then, we can redirected to submit pull request page that we can add description in there if needed and then, we can click "Create Pull Request" :
![2](https://cloud.githubusercontent.com/assets/459648/3942691/651fa9fa-2571-11e4-9a3b-bcf743fda02a.png)

So we can see :
![3](https://cloud.githubusercontent.com/assets/459648/3942693/6bbb197a-2571-11e4-8186-64d0b2d840b1.png)

After PR submitted, we can review the PR  :
![4](https://cloud.githubusercontent.com/assets/459648/3942694/71ef3fa6-2571-11e4-8c0f-0eb43a4e5bfa.png)


**Bug report/RFC feature :**
- Bug report and RFC can be an issue/PR. Bug Report/new module should pointed to **master**, and feature should pointed to **develop**.

**Merging PR ( For Maintainers )**
 * Always check if it is a bug fix/new module or a feature. bug fix/ new module should merged into master
```
git checkout master
git branch samsonasik/change-changelog
git checkout  samsonasik/change-changelog
git pull https://github.com/samsonasik/LearnZF2.git changelog
```
 * So, we will get console output :
```
  $ git pull https://github.com/samsonasik/LearnZF2.git changelog
From https://github.com/samsonasik/LearnZF2
 branch            changelog  -> FETCH_HEAD
Updating 41bef68..5352d3e
Fast-forward
 CHANGELOG.md | 6 ++++++
 1 file changed, 6 insertions(+)
 create mode 100644 CHANGELOG.md
```
 * Great! now, we can merge to master
```
git checkout master
git  merge --no-ff samsonasik/change-changelog
```
And in the our VIM, we can edit the merge commit message, as maintainer, commit merge should have PR #id for example :

```
Merge PR #12 from branch 'samsonasik/change-changelog'

# Please enter a commit message to explain why this merge is necessary,
# especially if it merges an updated upstream into a topic branch.
#
# Lines starting with '#' will be ignored, and an empty message aborts
# the commit.
```
We can change the commit message with type _i_ and change the message. After done, type : _:wq_.

**REMEMBER**, that merging bug fixes/new module to master should be forwarded to develop too so it will be syncronized.

You can do :
```
git checkout develop
git merge --no-ff --log master
```
Add 'port #id pr' message in the VIM during merging process master to develop.

**_If feature, it should be merged to develop only._**

After that, we can do :
```
git checkout master # ensure in master
git push https://github.com/sitrunlab/LearnZF2.git master
```
If you merged to develop to, you can do :
```
git checkout develop # ensure in develop
git push https://github.com/sitrunlab/LearnZF2.git develop
```


### Git Publish

It would be easier to use git flow to publish your branch, by git flow, you always use feature checked out from develop branch, and when you done and want to create a Pull Request, you can run :

git flow feature yourfeature publish

Next commit you need to push manually :

git push origin yourfeature

It seems more keywords, but it's just a little things for many elegant way to switching branch and merging with git flow. By running git flow, you have summary like :

$ git flow feature start download-plugin

Switched to a new branch **'feature/download-plugin'**

Summary of actions:
- A new branch 'feature/download-plugin' was created, based on 'develop'
- You are now on branch 'feature/download-plugin'

Now, start committing on your feature. When done, use:

git flow feature finish download-plugin
It would be very usefull when you want to managing hotfix that merge to develop and master automatically when finish a hotfix flow.

For full command, you can check [Git flow cheatsheet](http://danielkummer.github.io/git-flow-cheatsheet/)
