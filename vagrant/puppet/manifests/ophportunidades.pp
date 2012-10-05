
class ophportunidades {

  exec { "yum update":
    command => "yum -y update",
    path => "/usr/bin",
  }

  package { "git":
    ensure => present,
  }

}

class apache {

	package { "httpd":
		ensure => present,
	}

	package { "httpd-devel":
		ensure => present,
	}

	service { "httpd":
		ensure => running,
		require => Package["httpd"],
	}

}

class mysql {

	package { "mysql":
    ensure => present,
  }

	package { "mysql-server":
    ensure => present,
  }

  package { "mysql-devel":
    ensure => present,
  }

  service { "mysqld":
    ensure => running,
    require => Package["mysql-server"],
  }

}

class php {

	package { "php":
		ensure => present,
	}

	package { "php-mysql":
		ensure => present,
	}

	package { "php-common":
		ensure => present,
	}	

}

include ophportunidades
include apache
include mysql
include php