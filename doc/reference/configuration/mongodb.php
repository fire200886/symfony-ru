<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Doctrine MongoDB Configuration</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="doctrine-mongodb-configuration">
      <h1>Doctrine MongoDB Configuration<a class="headerlink" href="#doctrine-mongodb-configuration" title="Permalink to this headline">¶</a></h1>
      <div class="section" id="sample-configuration">
	<h2>Sample Configuration<a class="headerlink" href="#sample-configuration" title="Permalink to this headline">¶</a></h2>
	<div class="highlight-yaml"><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">doctrine_mongodb</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">connections</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">default</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">server</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">mongodb://localhost:27017</span>
            <span class="l-Scalar-Plain">options</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">connect</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">true</span>
    <span class="l-Scalar-Plain">default_database</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">hello_%kernel.environment%</span>
    <span class="l-Scalar-Plain">document_managers</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">default</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">mappings</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">AcmeDemoBundle</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
            <span class="l-Scalar-Plain">metadata_cache_driver</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">array</span> <span class="c1"># array, apc, xcache, memcache</span>
	  </pre></div>
	</div>
	<p>If you wish to use memcache to cache your metadata, you need to configure the
	  <tt class="docutils literal"><span class="pre">Memcache</span></tt> instance; for example, you can do the following:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 382px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">doctrine_mongodb</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">default_database</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">hello_%kernel.environment%</span>
    <span class="l-Scalar-Plain">connections</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">default</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">server</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">mongodb://localhost:27017</span>
            <span class="l-Scalar-Plain">options</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">connect</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">true</span>
    <span class="l-Scalar-Plain">document_managers</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">default</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">mappings</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">AcmeDemoBundle</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
            <span class="l-Scalar-Plain">metadata_cache_driver</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">type</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">memcache</span>
                <span class="l-Scalar-Plain">class</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Doctrine\Common\Cache\MemcacheCache</span>
                <span class="l-Scalar-Plain">host</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">localhost</span>
                <span class="l-Scalar-Plain">port</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">11211</span>
                <span class="l-Scalar-Plain">instance_class</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Memcache</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="cp">&lt;?xml version="1.0" ?&gt;</span>

<span class="nt">&lt;container</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/dic/services"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xmlns:doctrine_mongodb=</span><span class="s">"http://symfony.com/schema/dic/doctrine/odm/mongodb"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd</span>
<span class="s">                        http://symfony.com/schema/dic/doctrine/odm/mongodb http://symfony.com/schema/dic/doctrine/odm/mongodb/mongodb-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;doctrine_mongodb:config</span> <span class="na">default-database=</span><span class="s">"hello_%kernel.environment%"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;doctrine_mongodb:document-manager</span> <span class="na">id=</span><span class="s">"default"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;doctrine_mongodb:mapping</span> <span class="na">name=</span><span class="s">"AcmeDemoBundle"</span> <span class="nt">/&gt;</span>
            <span class="nt">&lt;doctrine_mongodb:metadata-cache-driver</span> <span class="na">type=</span><span class="s">"memcache"</span><span class="nt">&gt;</span>
                <span class="nt">&lt;doctrine_mongodb:class&gt;</span>Doctrine\Common\Cache\MemcacheCache<span class="nt">&lt;/doctrine_mongodb:class&gt;</span>
                <span class="nt">&lt;doctrine_mongodb:host&gt;</span>localhost<span class="nt">&lt;/doctrine_mongodb:host&gt;</span>
                <span class="nt">&lt;doctrine_mongodb:port&gt;</span>11211<span class="nt">&lt;/doctrine_mongodb:port&gt;</span>
                <span class="nt">&lt;doctrine_mongodb:instance-class&gt;</span>Memcache<span class="nt">&lt;/doctrine_mongodb:instance-class&gt;</span>
            <span class="nt">&lt;/doctrine_mongodb:metadata-cache-driver&gt;</span>
        <span class="nt">&lt;/doctrine_mongodb:document-manager&gt;</span>
        <span class="nt">&lt;doctrine_mongodb:connection</span> <span class="na">id=</span><span class="s">"default"</span> <span class="na">server=</span><span class="s">"mongodb://localhost:27017"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;doctrine_mongodb:options&gt;</span>
                <span class="nt">&lt;doctrine_mongodb:connect&gt;</span>true<span class="nt">&lt;/doctrine_mongodb:connect&gt;</span>
            <span class="nt">&lt;/doctrine_mongodb:options&gt;</span>
        <span class="nt">&lt;/doctrine_mongodb:connection&gt;</span>
    <span class="nt">&lt;/doctrine_mongodb:config&gt;</span>
<span class="nt">&lt;/container&gt;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="section" id="mapping-configuration">
	  <h3>Mapping Configuration<a class="headerlink" href="#mapping-configuration" title="Permalink to this headline">¶</a></h3>
	  <p>Explicit definition of all the mapped documents is the only necessary
	    configuration for the ODM and there are several configuration options that you
	    can control. The following configuration options exist for a mapping:</p>
	  <ul class="simple">
	    <li><tt class="docutils literal"><span class="pre">type</span></tt> One of <tt class="docutils literal"><span class="pre">annotations</span></tt>, <tt class="docutils literal"><span class="pre">xml</span></tt>, <tt class="docutils literal"><span class="pre">yml</span></tt>, <tt class="docutils literal"><span class="pre">php</span></tt> or <tt class="docutils literal"><span class="pre">staticphp</span></tt>.
	      This specifies which type of metadata type your mapping uses.</li>
	    <li><tt class="docutils literal"><span class="pre">dir</span></tt> Path to the mapping or entity files (depending on the driver). If
	      this path is relative it is assumed to be relative to the bundle root. This
	      only works if the name of your mapping is a bundle name. If you want to use
	      this option to specify absolute paths you should prefix the path with the
	      kernel parameters that exist in the DIC (for example %kernel.root_dir%).</li>
	    <li><tt class="docutils literal"><span class="pre">prefix</span></tt> A common namespace prefix that all documents of this mapping
	      share. This prefix should never conflict with prefixes of other defined
	      mappings otherwise some of your documents cannot be found by Doctrine. This
	      option defaults to the bundle namespace + <tt class="docutils literal"><span class="pre">Document</span></tt>, for example for an
	      application bundle called <tt class="docutils literal"><span class="pre">AcmeHelloBundle</span></tt>, the prefix would be
	      <tt class="docutils literal"><span class="pre">Acme\HelloBundle\Document</span></tt>.</li>
	    <li><tt class="docutils literal"><span class="pre">alias</span></tt> Doctrine offers a way to alias document namespaces to simpler,
	      shorter names to be used in queries or for Repository access.</li>
	    <li><tt class="docutils literal"><span class="pre">is_bundle</span></tt> This option is a derived value from <tt class="docutils literal"><span class="pre">dir</span></tt> and by default is
	      set to true if dir is relative proved by a <tt class="docutils literal"><span class="pre">file_exists()</span></tt> check that
	      returns false. It is false if the existence check returns true. In this case
	      an absolute path was specified and the metadata files are most likely in a
	      directory outside of a bundle.</li>
	  </ul>
	  <p>To avoid having to configure lots of information for your mappings you should
	    follow these conventions:</p>
	  <ol class="arabic simple">
	    <li>Put all your documents in a directory <tt class="docutils literal"><span class="pre">Document/</span></tt> inside your bundle. For
	      example <tt class="docutils literal"><span class="pre">Acme/HelloBundle/Document/</span></tt>.</li>
	    <li>If you are using xml, yml or php mapping put all your configuration files
	      into the <tt class="docutils literal"><span class="pre">Resources/config/doctrine/</span></tt> directory
	      suffixed with mongodb.xml, mongodb.yml or mongodb.php respectively.</li>
	    <li>Annotations is assumed if an <tt class="docutils literal"><span class="pre">Document/</span></tt> but no
	      <tt class="docutils literal"><span class="pre">Resources/config/doctrine/</span></tt> directory is found.</li>
	  </ol>
	  <p>The following configuration shows a bunch of mapping examples:</p>
	  <div class="highlight-yaml"><pre>doctrine_mongodb:
    document_managers:
        default:
            mappings:
                MyBundle1: ~
                MyBundle2: yml
                MyBundle3: { type: annotation, dir: Documents/ }
                MyBundle4: { type: xml, dir: Resources/config/doctrine/mapping }
                MyBundle5:
                    type: yml
                    dir: my-bundle-mappings-dir
                    alias: BundleAlias
                doctrine_extensions:
                    type: xml
                    dir: %kernel.root_dir%/../src/vendor/DoctrineExtensions/lib/DoctrineExtensions/Documents
                    prefix: DoctrineExtensions\Documents\
              alias: DExt</pre>
	  </div>
	</div>
	<div class="section" id="multiple-connections">
	  <h3>Multiple Connections<a class="headerlink" href="#multiple-connections" title="Permalink to this headline">¶</a></h3>
	  <p>If you need multiple connections and document managers you can use the
	    following syntax:</p>
	  <p>Now you can retrieve the configured services connection services:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$conn1</span> <span class="o">=</span> <span class="nv">$container</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine.odm.mongodb.conn1_connection'</span><span class="p">);</span>
<span class="nv">$conn2</span> <span class="o">=</span> <span class="nv">$container</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine.odm.mongodb.conn2_connection'</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>And you can also retrieve the configured document manager services which utilize the above
	    connection services:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$dm1</span> <span class="o">=</span> <span class="nv">$container</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine.odm.mongodb.dm1_document_manager'</span><span class="p">);</span>
<span class="nv">$dm2</span> <span class="o">=</span> <span class="nv">$container</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine.odm.mongodb.dm2_document_manager'</span><span class="p">);</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="full-default-configuration">
	  <h3>Full Default Configuration<a class="headerlink" href="#full-default-configuration" title="Permalink to this headline">¶</a></h3>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 886px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre>doctrine_mongodb:
    document_managers:

        # Prototype
        id:
            connection:           ~
            database:             ~
            logging:              true
            auto_mapping:         false
            metadata_cache_driver:
                type:                 ~
                class:                ~
                host:                 ~
                port:                 ~
                instance_class:       ~
            mappings:

                # Prototype
                name:
                    mapping:              true
                    type:                 ~
                    dir:                  ~
                    prefix:               ~
                    alias:                ~
                    is_bundle:            ~
    connections:

        # Prototype
        id:
            server:               ~
            options:
                connect:              ~
                persist:              ~
                timeout:              ~
                replicaSet:           ~
                username:             ~
                password:             ~
    proxy_namespace:      Proxies
    proxy_dir:            %kernel.cache_dir%/doctrine/odm/mongodb/Proxies
    auto_generate_proxy_classes:  false
    hydrator_namespace:   Hydrators
    hydrator_dir:         %kernel.cache_dir%/doctrine/odm/mongodb/Hydrators
    auto_generate_hydrator_classes:  false
    default_document_manager:  ~
    default_connection:   ~
		    default_database:     default</pre>
		</div>
	      </li>
	    </ul>
	  </div>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="WebProfilerBundle Configuration" href="web_profiler.html">
      «&nbsp;WebProfilerBundle Configuration
    </a><span class="separator">|</span>
    <a accesskey="N" title="Form Types Reference" href="../forms/types.html">
      Form Types Reference&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
