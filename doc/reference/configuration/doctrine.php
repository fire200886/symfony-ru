<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Configuration Reference</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="configuration-reference">
      <span id="index-0"></span><h1>Configuration Reference<a class="headerlink" href="#configuration-reference" title="Permalink to this headline">¶</a></h1>
      <div class="configuration-block jsactive clearfix">
	<ul class="simple" style="height: 1063px; ">
	  <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre>doctrine:
    dbal:
        default_connection:   default
        connections:
            default:
                dbname:               database
                host:                 localhost
                port:                 1234
                user:                 user
                password:             secret
                driver:               pdo_mysql
                driver_class:         MyNamespace\MyDriverImpl
                options:
                    foo: bar
                path:                 %kernel.data_dir%/data.sqlite
                memory:               true
                unix_socket:          /tmp/mysql.sock
                wrapper_class:        MyDoctrineDbalConnectionWrapper
                charset:              UTF8
                logging:              %kernel.debug%
                platform_service:     MyOwnDatabasePlatformService
            conn1:
                # ...
        types:
            custom: Acme\HelloBundle\MyCustomType
    orm:
        auto_generate_proxy_classes:    true
        proxy_namespace:                Proxies
        proxy_dir:                      %kernel.cache_dir%/doctrine/orm/Proxies
        default_entity_manager:         default # The first defined is used if not set
        entity_managers:
            default:
                # The name of a DBAL connection (the one marked as default is used if not set)
                connection:                     conn1
                mappings: # Required
                    AcmeHelloBundle: ~
                class_metadata_factory_name:    Doctrine\ORM\Mapping\ClassMetadataFactory
                # All cache drivers have to be array, apc, xcache or memcache
                metadata_cache_driver:          array
                query_cache_driver:             array
                result_cache_driver:
                    type:           memcache
                    host:           localhost
                    port:           11211
                    instance_class: Memcache
                    class:          Doctrine\Common\Cache\MemcacheCache
                dql:
                    string_functions:
                        test_string: Acme\HelloBundle\DQL\StringFunction
                    numeric_functions:
                        test_numeric: Acme\HelloBundle\DQL\NumericFunction
                    datetime_functions:
                        test_datetime: Acme\HelloBundle\DQL\DatetimeFunction
            em2:
                # ...</pre>
	    </div>
	  </li>
	  <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><pre>&lt;container xmlns="http://symfony.com/schema/dic/services"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns:doctrine="http://symfony.com/schema/dic/doctrine"
    xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd
                        http://symfony.com/schema/dic/doctrine http://symfony.com/schema/dic/doctrine/doctrine-1.0.xsd"&gt;

    &lt;doctrine:config&gt;
        &lt;doctrine:dbal default-connection="default"&gt;
            &lt;doctrine:connection
                name="default"
                dbname="database"
                host="localhost"
                port="1234"
                user="user"
                password="secret"
                driver="pdo_mysql"
                driver-class="MyNamespace\MyDriverImpl"
                path="%kernel.data_dir%/data.sqlite"
                memory="true"
                unix-socket="/tmp/mysql.sock"
                wrapper-class="MyDoctrineDbalConnectionWrapper"
                charset="UTF8"
                logging="%kernel.debug%"
                platform-service="MyOwnDatabasePlatformService"
            /&gt;
            &lt;doctrine:connection name="conn1" /&gt;
            &lt;doctrine:type name="custom" class="Acme\HelloBundle\MyCustomType" /&gt;
        &lt;/doctrine:dbal&gt;

        &lt;doctrine:orm default-entity-manager="default" auto-generate-proxy-classes="true" proxy-namespace="Proxies" proxy-dir="%kernel.cache_dir%/doctrine/orm/Proxies"&gt;
            &lt;doctrine:entity-manager name="default" query-cache-driver="array" result-cache-driver="array" connection="conn1" class-metadata-factory-name="Doctrine\ORM\Mapping\ClassMetadataFactory"&gt;
                &lt;doctrine:metadata-cache-driver type="memcache" host="localhost" port="11211" instance-class="Memcache" class="Doctrine\Common\Cache\MemcacheCache" /&gt;
                &lt;doctrine:mapping name="AcmeHelloBundle" /&gt;
                &lt;doctrine:dql&gt;
                    &lt;doctrine:string-function name="test_string&gt;Acme\HelloBundle\DQL\StringFunction&lt;/doctrine:string-function&gt;
                    &lt;doctrine:numeric-function name="test_numeric&gt;Acme\HelloBundle\DQL\NumericFunction&lt;/doctrine:numeric-function&gt;
                    &lt;doctrine:datetime-function name="test_datetime&gt;Acme\HelloBundle\DQL\DatetimeFunction&lt;/doctrine:datetime-function&gt;
                &lt;/doctrine:dql&gt;
            &lt;/doctrine:entity-manager&gt;
            &lt;doctrine:entity-manager name="em2" connection="conn2" metadata-cache-driver="apc"&gt;
                &lt;doctrine:mapping
                    name="DoctrineExtensions"
                    type="xml"
                    dir="%kernel.root_dir%/../src/vendor/DoctrineExtensions/lib/DoctrineExtensions/Entity"
                    prefix="DoctrineExtensions\Entity"
                    alias="DExt"
                /&gt;
            &lt;/doctrine:entity-manager&gt;
        &lt;/doctrine:orm&gt;
    &lt;/doctrine:config&gt;
		&lt;/container&gt;</pre>
	    </div>
	  </li>
	</ul>
      </div>
      <div class="section" id="configuration-overview">
	<h2>Configuration Overview<a class="headerlink" href="#configuration-overview" title="Permalink to this headline">¶</a></h2>
	<p>This following configuration example shows all the configuration defaults that
	  the ORM resolves to:</p>
	<div class="highlight-yaml"><pre>doctrine:
    orm:
        auto_mapping: true
        auto_generate_proxy_classes: true
        proxy_namespace: Proxies
        proxy_dir: %kernel.cache_dir%/doctrine/orm/Proxies
        default_entity_manager: default
        metadata_cache_driver: array
        query_cache_driver: array
            result_cache_driver: array</pre>
	</div>
	<p>There are lots of other configuration options that you can use to overwrite
	  certain classes, but those are for very advanced use-cases only.</p>
	<div class="section" id="caching-drivers">
	  <h3>Caching Drivers<a class="headerlink" href="#caching-drivers" title="Permalink to this headline">¶</a></h3>
	  <p>For the caching drivers you can specify the values "array", "apc", "memcache"
	    or "xcache".</p>
	  <p>The following example shows an overview of the caching configurations:</p>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="l-Scalar-Plain">doctrine</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">orm</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">auto_mapping</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">true</span>
        <span class="l-Scalar-Plain">metadata_cache_driver</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">apc</span>
        <span class="l-Scalar-Plain">query_cache_driver</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">xcache</span>
        <span class="l-Scalar-Plain">result_cache_driver</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">type</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">memcache</span>
            <span class="l-Scalar-Plain">host</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">localhost</span>
            <span class="l-Scalar-Plain">port</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">11211</span>
            <span class="l-Scalar-Plain">instance_class</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Memcache</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="mapping-configuration">
	  <h3>Mapping Configuration<a class="headerlink" href="#mapping-configuration" title="Permalink to this headline">¶</a></h3>
	  <p>Explicit definition of all the mapped entities is the only necessary
	    configuration for the ORM and there are several configuration options that you
	    can control. The following configuration options exist for a mapping:</p>
	  <ul class="simple">
	    <li><tt class="docutils literal"><span class="pre">type</span></tt> One of <tt class="docutils literal"><span class="pre">annotation</span></tt>, <tt class="docutils literal"><span class="pre">xml</span></tt>, <tt class="docutils literal"><span class="pre">yml</span></tt>, <tt class="docutils literal"><span class="pre">php</span></tt> or <tt class="docutils literal"><span class="pre">staticphp</span></tt>.
	      This specifies which type of metadata type your mapping uses.</li>
	    <li><tt class="docutils literal"><span class="pre">dir</span></tt> Path to the mapping or entity files (depending on the driver). If
	      this path is relative it is assumed to be relative to the bundle root. This
	      only works if the name of your mapping is a bundle name. If you want to use
	      this option to specify absolute paths you should prefix the path with the
	      kernel parameters that exist in the DIC (for example %kernel.root_dir%).</li>
	    <li><tt class="docutils literal"><span class="pre">prefix</span></tt> A common namespace prefix that all entities of this mapping
	      share. This prefix should never conflict with prefixes of other defined
	      mappings otherwise some of your entities cannot be found by Doctrine. This
	      option defaults to the bundle namespace + <tt class="docutils literal"><span class="pre">Entity</span></tt>, for example for an
	      application bundle called <tt class="docutils literal"><span class="pre">AcmeHelloBundle</span></tt> prefix would be
	      <tt class="docutils literal"><span class="pre">Acme\HelloBundle\Entity</span></tt>.</li>
	    <li><tt class="docutils literal"><span class="pre">alias</span></tt> Doctrine offers a way to alias entity namespaces to simpler,
	      shorter names to be used in DQL queries or for Repository access. When using
	      a bundle the alias defaults to the bundle name.</li>
	    <li><tt class="docutils literal"><span class="pre">is_bundle</span></tt> This option is a derived value from <tt class="docutils literal"><span class="pre">dir</span></tt> and by default is
	      set to true if dir is relative proved by a <tt class="docutils literal"><span class="pre">file_exists()</span></tt> check that
	      returns false. It is false if the existence check returns true. In this case
	      an absolute path was specified and the metadata files are most likely in a
	      directory outside of a bundle.</li>
	  </ul>
	</div>
      </div>
      <div class="section" id="doctrine-dbal-configuration">
	<span id="reference-dbal-configuration"></span><span id="index-1"></span><h2>Doctrine DBAL Configuration<a class="headerlink" href="#doctrine-dbal-configuration" title="Permalink to this headline">¶</a></h2>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">DoctrineBundle supports all parameters that default Doctrine drivers
	      accept, converted to the XML or YAML naming standards that Symfony
	      enforces. See the Doctrine <a class="reference external" href="http://www.doctrine-project.org/docs/dbal/2.0/en">DBAL documentation</a> for more information.</p>
	</div></div>
	<p>Besides default Doctrine options, there are some Symfony-related ones that you
	  can configure. The following block shows all possible configuration keys:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 382px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre>doctrine:
    dbal:
        dbname:               database
        host:                 localhost
        port:                 1234
        user:                 user
        password:             secret
        driver:               pdo_mysql
        driver_class:         MyNamespace\MyDriverImpl
        options:
            foo: bar
        path:                 %kernel.data_dir%/data.sqlite
        memory:               true
        unix_socket:          /tmp/mysql.sock
        wrapper_class:        MyDoctrineDbalConnectionWrapper
        charset:              UTF8
        logging:              %kernel.debug%
		  platform_service:     MyOwnDatabasePlatformService</pre>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- xmlns:doctrine="http://symfony.com/schema/dic/doctrine" --&gt;</span>
<span class="c">&lt;!-- xsi:schemaLocation="http://symfony.com/schema/dic/doctrine http://symfony.com/schema/dic/doctrine/doctrine-1.0.xsd"&gt; --&gt;</span>

<span class="nt">&lt;doctrine:config&gt;</span>
    <span class="nt">&lt;doctrine:dbal</span>
        <span class="na">name=</span><span class="s">"default"</span>
        <span class="na">dbname=</span><span class="s">"database"</span>
        <span class="na">host=</span><span class="s">"localhost"</span>
        <span class="na">port=</span><span class="s">"1234"</span>
        <span class="na">user=</span><span class="s">"user"</span>
        <span class="na">password=</span><span class="s">"secret"</span>
        <span class="na">driver=</span><span class="s">"pdo_mysql"</span>
        <span class="na">driver-class=</span><span class="s">"MyNamespace\MyDriverImpl"</span>
        <span class="na">path=</span><span class="s">"%kernel.data_dir%/data.sqlite"</span>
        <span class="na">memory=</span><span class="s">"true"</span>
        <span class="na">unix-socket=</span><span class="s">"/tmp/mysql.sock"</span>
        <span class="na">wrapper-class=</span><span class="s">"MyDoctrineDbalConnectionWrapper"</span>
        <span class="na">charset=</span><span class="s">"UTF8"</span>
        <span class="na">logging=</span><span class="s">"%kernel.debug%"</span>
        <span class="na">platform-service=</span><span class="s">"MyOwnDatabasePlatformService"</span>
    <span class="nt">/&gt;</span>
<span class="nt">&lt;/doctrine:config&gt;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>If you want to configure multiple connections in YAML, put them under the
	  <tt class="docutils literal"><span class="pre">connections</span></tt> key and give them a unique name:</p>
	<div class="highlight-yaml"><div class="highlight"><pre><span class="l-Scalar-Plain">doctrine</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">dbal</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">default_connection</span><span class="p-Indicator">:</span>       <span class="l-Scalar-Plain">default</span>
        <span class="l-Scalar-Plain">connections</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">default</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">dbname</span><span class="p-Indicator">:</span>           <span class="l-Scalar-Plain">Symfony2</span>
                <span class="l-Scalar-Plain">user</span><span class="p-Indicator">:</span>             <span class="l-Scalar-Plain">root</span>
                <span class="l-Scalar-Plain">password</span><span class="p-Indicator">:</span>         <span class="l-Scalar-Plain">null</span>
                <span class="l-Scalar-Plain">host</span><span class="p-Indicator">:</span>             <span class="l-Scalar-Plain">localhost</span>
            <span class="l-Scalar-Plain">customer</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">dbname</span><span class="p-Indicator">:</span>           <span class="l-Scalar-Plain">customer</span>
                <span class="l-Scalar-Plain">user</span><span class="p-Indicator">:</span>             <span class="l-Scalar-Plain">root</span>
                <span class="l-Scalar-Plain">password</span><span class="p-Indicator">:</span>         <span class="l-Scalar-Plain">null</span>
                <span class="l-Scalar-Plain">host</span><span class="p-Indicator">:</span>             <span class="l-Scalar-Plain">localhost</span>
	  </pre></div>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">database_connection</span></tt> service always refers to the <em>default</em> connection,
	  which is the first one defined or the one configured via the
	  <tt class="docutils literal"><span class="pre">default_connection</span></tt> parameter.</p>
	<p>Each connection is also accessible via the <tt class="docutils literal"><span class="pre">doctrine.dbal.[name]_connection</span></tt>
	  service where <tt class="docutils literal"><span class="pre">[name]</span></tt> if the name of the connection.</p>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="AsseticBundle Configuration Reference" href="assetic.html">
      «&nbsp;AsseticBundle Configuration Reference
    </a><span class="separator">|</span>
    <a accesskey="N" title="Security Configuration Reference" href="security.html">
      Security Configuration Reference&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
