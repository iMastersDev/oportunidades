# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant::Config.run do |config|
  config.vm.box = "CentOS-6.3-x86_64-minimal"

  config.vm.box_url = "https://dl.dropbox.com/u/7225008/Vagrant/CentOS-6.3-x86_64-minimal.box"

  config.vm.network :hostonly, "127.0.0.2"

  config.vm.forward_port 80, 8080

  config.vm.share_folder "v-root", "/vagrant", "../"

  config.vm.provision :puppet do |puppet|
    puppet.options        = "--verbose --debug"
    puppet.manifests_path = "puppet/manifests"
    puppet.manifest_file  = "ophportunidades.pp"
  end

end
