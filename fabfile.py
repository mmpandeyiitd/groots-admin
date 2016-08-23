from fabric.api import *
#fab -Hsysadmin@cms.proptiger.com deploy_tag:tagname  this is the command for the code to be deployed on noida-2 server
def deploy_tag(tag):
  local("git archive --format tar.gz --output /tmp/cms.tar.gz refs/tags/%s^{}" %(tag))
  put('/tmp/cms.tar.gz', '/tmp')
  run("cd /home/sysadmin && mkdir cms_new && cd cms_new && tar -xf /tmp/cms.tar.gz && ln -s /home/sysadmin/public_html/images_new images_new && cp -r /home/sysadmin/cms_config_prod/* . && cd /home/sysadmin && mv production_cms cms_old && mv cms_new production_cms && echo %s > production_cms/version && sudo rm -rf /tmp/*.tpl.php && rm -r cms_old && touch production_cms/.production" %(tag))

#fab -Hsysadmin@cms.proptiger-ws.com deploy_stg_branch:branchname  this is the command for the code to be deployed on staging server
def deploy_stg_branch(branch):
  local("git archive --format tar.gz --output /tmp/cms.tar.gz remotes/origin/%s" %(branch))
  put('/tmp/cms.tar.gz', '/tmp')
  run("cd /home/sysadmin && mkdir cms_new && cd cms_new && tar -xf /tmp/cms.tar.gz && ln -s /home/sysadmin/public_html/images_new images_new && cp -r /home/sysadmin/cms_config_staging/* . && cd /home/sysadmin && mv cms cms_old && mv cms_new cms && echo %s > cms/version && sudo rm -rf /tmp/*.tpl.php && rm -r cms_old" %(branch))

#fab -Hsysadmin@cmsdev.proptiger-ws.com deploy_dev_branch:branchname  this is the command for the code to be deployed on dev server
def deploy_dev_branch(branch):
  local("git archive --format tar.gz --output /tmp/cmsdev.tar.gz remotes/origin/%s" %(branch))
  put('/tmp/cmsdev.tar.gz', '/tmp')
  run("cd /home/sysadmin && mkdir cmsdev_new && cd cmsdev_new && tar -xf /tmp/cmsdev.tar.gz && ln -s /home/sysadmin/public_html/images_new images_new  && cp -r /home/sysadmin/cms_config_staging/* . && cd /home/sysadmin && mv cmsdev cmsdev_old && mv cmsdev_new cmsdev && echo %s > cmsdev/version && sudo rm -rf /tmp/*.tpl.php && rm -r cmsdev_old" %(branch))




#fab -Hubuntu@52.220.31.193 deploy_tag:tagname  this is the command for the code to be deployed on aws server
def deploy_tag(tag):
  local("git archive --format tar.gz --output /tmp/admin.tar.gz refs/tags/%s^{}" %(tag))
  put('/tmp/admin.tar.gz', '/tmp')
  run("cd /var/www/html && mkdir admin_new && cd admin_new && tar -xf /tmp/admin.tar.gz && cp -r ../main.php admin/code/protected/config/main.php  && cd /var/www/html && mv admin admin_old && mv admin_new admin && echo %s > admin/version && sudo rm -r admin_old && touch admin/.production" %(tag))
