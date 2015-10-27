## Magento Extension 

Predictry's service extension for Magento eCommerce platform.

### Usage
1. Download the Plugin from predictry.com
2. Install it (System > Magento Connect > Magento Connect Manager)
3. Setup basic configuration such as Tenant ID, API Key, etc (System > Predictry Recommendation)
4. Create widget and place it on any template you want. (CMS > Widget > Add New Widget Instance)

Enjoy!

#### DevEnv Installation
1. Clone this repo and `cd` into it
2. Initialize magento2 submodule: `git submodule update --init`
3. start up virtual machine: `vagrant up`
4. Point a host name to 192.168.56.10 in /etc/hosts `echo '192.168.56.10 mage2.dev' >> /etc/hosts`
5. Once the machine completes provisioning, SSH to the server and install using composer `vagrant ssh; cd /vagrant/data/magento2; composer install;`
6. Install by using the following commands

```
$ vagrant ssh
$ cd /vagrant/data/magento2/
$ reinstall -s
```

#### Updating

* If there is an update to the *manifests/mage.pp* or *files/** files it is recommended to provision the guest machine. This can be done by running: `vagrant provision`. There is also a cron that runs every 15 minutes to 
provision within the guest machine in the event it's not done after updating. 


### Magento Admin User
* Username: admin
* Password: password123

### Database Info
* Username: root
* Password: mage2
* DB Name: mage2

### SSH Info
* username: vagrant
* password: vagrant 

It's also possible to use `vagrant ssh` from within the project directory

## File Structure

### Host Machine / Project directory
* manifests/mage.pp - Puppet manifest file
* files/ - contains various service configuration files
  * bash_aliases - vagrant user bash aliases script
  * fastcgi.conf - fastcgi configuration
  * reinstall.sh - magento reinstall wrapper script
  * site.conf - apache virtual host configuration
  * www.conf - php-fpm pool configuration
  * xdebug.ini - php xdebug configuration file
* data/magento2 - git submodule to magento2 github repository. 
 

### Plugin source 
* ./app
* archive it to release 

