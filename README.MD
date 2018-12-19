## HTACCESS Checker Tool. 
The tool provides ability to compare .htaccess file what is build via htaccess builder with old one version .htaccess file. 
### Installation. 
1. Clone the tool from git repo e.g: _/home/developer/Tools/htaccess_checker_. 
2. And new virtual host with docroot to the folder e.g: [htaccess_checker.conf](configs/htaccess_checker.conf).
3. Restart Virtual server. 
4. Open the domain http://htaccess_checker.local/ in your browser and make sure that works.  
5. Make the copy_htaccess_files.sh file executable.  

### Logic of comparison. 
The new one .htaccess file contains a lot of blocks like
```
  # aveeno_us start.
  # Aveeno US URL Redirect
  RewriteCond %{HTTP_HOST} ^aveeno\.com$                        [NC]
  RewriteRule ^/?(.*)$ https://www.aveeno.com/$1                [R=permanent,L]
  # aveeno_us end.
```
The tool via regex looks for the block between 
```
# aveeno_us start.
....
# aveeno_us end.
```
and then tries to match the blocks in _htaccess_old.txt_. 
If the block
```
  # Aveeno US URL Redirect
  RewriteCond %{HTTP_HOST} ^aveeno\.com$                        [NC]
  RewriteRule ^/?(.*)$ https://www.aveeno.com/$1                [R=permanent,L]
```
found in _htaccess_old.txt_ it is considered that htaccess rule for aveeno_us passed comparison.    
The result of work of tool is two generated files
```
files/new_htaccess_draft.txt - copied from htaccess_new.txt, but doesn't contain all matched blocks. 
files/old_htaccess_draft.txt - copied from htaccess_old.txt, but doesn't contain all matched blocks. 
```
### Usage. 
1. Copy new .htaccess file to _files_ folder with _htaccess_new.txt_ name.
Execute: ./scripts/copy_htaccess_files.sh @jnjemeab32d3.dev htaccess_new.txt  
2. Copy old .htaccess file to _files_ folder with _htaccess_old.txt_ name.
3. Open in your browser http://htaccess_checker.local/
4. Check of message in panel _1. Amount of matched sites_
Amount of site should be the same with site on DP/Ctech Jenkins for the subscription. 
5. Check of message in panel: _2. Sites with not matched htaccess blocks_
If there are detected not matched sites. It means need investigate why htaccess block for the site are not matched in both of the htaccess files.
6. Compare new_htaccess_draft.txt and old_htaccess_draft.txt. 
The files will be slightly different. But need to do research of the diff. 

 
   