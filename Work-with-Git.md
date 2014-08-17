
#Work with Git


**Code :** 

 _1. Fork repository_

Sebelum memulai pertama, kita fork dulu repository ini dari button "fork" di menu sebelah kanan atas ke akun github kita masing2.

 _2. PRs_

Selalu mengajukan rancangan coding dengan PR ( Pull Request ). Langkah2 : 
 * Clone ke local komputer kita dari forked repository di akun kita.
```
   git clone https://github.com/samsonasik/LearnZF2.git OurLocalLearnZF2Repository
```
 * Membuat branch baru , misal branch baru bernama 'changelog' :
```
git checkout master #always start with it to make sure we are from master
git branch changelog
```
 * Checkout ke branch tersebut 
```
git checkout changelog
```
 * Lakukan perubahan dan commit dan push ke akun kita : 
```
git commit -m "commit message" -a
git push origin changelog
```
 * Lakukan pull request
Di forked akun kita : _/akunkita/LearnZF2_ akan ada button "Compare and Create Pull Request", nah kita klik : 
![1](https://cloud.githubusercontent.com/assets/459648/3942685/5da25e34-2571-11e4-8453-00178259aad3.png)

Lalu masuk halaman submit pull request yang kita bisa isi dengan deskripsi ( jika perlu ) dan kita bisa klik button "Create Pull Request" :
![2](https://cloud.githubusercontent.com/assets/459648/3942691/651fa9fa-2571-11e4-9a3b-bcf743fda02a.png)

Sehingga kita bisa lihat hasilnya di list PR : 
![3](https://cloud.githubusercontent.com/assets/459648/3942693/6bbb197a-2571-11e4-8186-64d0b2d840b1.png)


Setelah PR disubmit, kita bisa review seperti di gambar berikut :
![4](https://cloud.githubusercontent.com/assets/459648/3942694/71ef3fa6-2571-11e4-8c0f-0eb43a4e5bfa.png)


**Bug report/RFC feature :** 
**TODO**

**Merging PR**
 * selalu mulai dengan master branch
```
git checkout master
```
 * buat branch baru 
```
git branch samsonasik/change-changelog
```
 * checkout dan pull dari branch nya yang ada di PR : 
```
git checkout  samsonasik/change-changelog
git pull https://github.com/samsonasik/LearnZF2.git changelog
```

 * maka kita akan dapat console tampilan seperti berikut : 
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
 * nah, kita balik ke master dan merge 
```
git checkout master
git  merge --no-ff samsonasik/change-changelog
```
dan kita akan dapat tampilan vim: 

```
Merge branch 'samsonasik/change-changelog'

# Please enter a commit message to explain why this merge is necessary,
# especially if it merges an updated upstream into a topic branch.
#
# Lines starting with '#' will be ignored, and an empty message aborts
# the commit.
```
kita bisa ubah dengan klik keyboard _i_ dan ubah yang tidak ada # nya ( # diabaikan dari commit message ).
terus kalau sudah selesai, kita ketik _:wq_.

kalau sudah, kita bisa git push deh ke repository /sitrunlab/LearnZF2 langsung : 
```
git push https://github.com/sitrunlab/LearnZF2.git master
```
