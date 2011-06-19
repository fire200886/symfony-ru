<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">
  <div class="box_title">
    <h1 class="title_01">How to use MongoDB</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-use-mongodb">
      <h1>How to use MongoDB<a class="headerlink" href="#how-to-use-mongodb" title="Permalink to this headline">¶</a></h1>
      <p id="index-0">The <a class="reference external" href="http://www.mongodb.org/">MongoDB</a> Object Document Mapper is much like the Doctrine2 ORM in the way
	it works and architecture. You only deal with plain PHP objects and they are
	persisted transparently without imposing on your domain model.</p>
      <div class="admonition-wrapper">
	<div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	  <p class="last">You can read more about the Doctrine MongoDB Object Document Mapper on the
	    projects <a class="reference external" href="http://www.doctrine-project.org/docs/mongodb_odm/1.0/en">documentation</a>.</p>
      </div></div>
      <p>To get started working with Doctrine and the MongoDB Object Document Mapper you
	just need to enable it and specify the bundle that contains your mapped documents:</p>
      <div class="highlight-yaml"><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>

<span class="l-Scalar-Plain">doctrine_mongodb</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">document_managers</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">default</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">mappings</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">AcmeHelloBundle</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
	</pre></div>
      </div>
      <p>Now you can start writing documents and mapping them with annotations, xml or
	yaml.</p>
      <div class="configuration-block jsactive clearfix">
	<ul class="simple" style="height: 940px; ">
	  <li class="selected"><em><a href="#">Annotations</a></em><div class="highlight-php-annotations" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1">// Acme/HelloBundle/Document/User.php</span>

<span class="k">namespace</span> <span class="nx">Acme\HelloBundle\Document</span><span class="p">;</span>

<span class="sd">/**</span>
<span class="sd"> * @mongodb:Document(collection="users")</span>
<span class="sd"> */</span>
<span class="k">class</span> <span class="nc">User</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @mongodb:Id</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$id</span><span class="p">;</span>

    <span class="sd">/**</span>
<span class="sd">     * @mongodb:Field(type="string")</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$name</span><span class="p">;</span>

    <span class="sd">/**</span>
<span class="sd">     * Get id</span>
<span class="sd">     *</span>
<span class="sd">     * @return integer $id</span>
<span class="sd">     */</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">getId</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">id</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="sd">/**</span>
<span class="sd">     * Set name</span>
<span class="sd">     *</span>
<span class="sd">     * @param string $name</span>
<span class="sd">     */</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">setName</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">name</span> <span class="o">=</span> <span class="nv">$name</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="sd">/**</span>
<span class="sd">     * Get name</span>
<span class="sd">     *</span>
<span class="sd">     * @return string $name</span>
<span class="sd">     */</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">getName</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">name</span><span class="p">;</span>
    <span class="p">}</span>
<span class="p">}</span>
	      </pre></div>
	    </div>
	  </li>
	  <li><em><a href="#">YAML</a></em><div class="highlight-yaml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1"># Acme/HelloBundle/Resources/config/doctrine/Acme.HelloBundle.Document.User.mongodb.yml</span>
<span class="l-Scalar-Plain">Acme\HelloBundle\Document\User</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">type</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">document</span>
    <span class="l-Scalar-Plain">collection</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">user</span>
    <span class="l-Scalar-Plain">fields</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">id</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">id</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">true</span>
        <span class="l-Scalar-Plain">name</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">type</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">string</span>
            <span class="l-Scalar-Plain">length</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">255</span>
	      </pre></div>
	    </div>
	  </li>
	  <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- Acme/HelloBundle/Resources/config/doctrine/Acme.HelloBundle.Document.User.mongodb.xml --&gt;</span>
<span class="nt">&lt;doctrine-mapping</span> <span class="na">xmlns=</span><span class="s">"http://doctrine-project.org/schemas/orm/doctrine-mapping"</span>
      <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
      <span class="na">xsi:schemaLocation=</span><span class="s">"http://doctrine-project.org/schemas/orm/doctrine-mapping</span>
<span class="s">                    http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;document</span> <span class="na">name=</span><span class="s">"Acme\HelloBundle\Document\User"</span> <span class="na">collection=</span><span class="s">"user"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">"id"</span> <span class="na">id=</span><span class="s">"true"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">"name"</span> <span class="na">type=</span><span class="s">"string"</span> <span class="na">length=</span><span class="s">"255"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/document&gt;</span>

<span class="nt">&lt;/doctrine-mapping&gt;</span>
	      </pre></div>
	    </div>
	  </li>
	</ul>
      </div>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p class="last">When using annotations in your Symfony2 project you have to namespace all
	    Doctrine MongoDB annotations with the <tt class="docutils literal"><span class="pre">mongodb:</span></tt> prefix.</p>
      </div></div>
      <div class="admonition-wrapper">
	<div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	  <p class="last">If you use YAML or XML to describe your documents, you can omit the creation
	    of the Document class, and let the <tt class="docutils literal"><span class="pre">doctrine:generate:documents</span></tt> command
	    do it for you.</p>
      </div></div>
      <p>Now, use your document and manage its persistent state with Doctrine:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Acme\HelloBundle\Document\User</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">UserController</span> <span class="k">extends</span> <span class="nx">Controller</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">createAction</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="nv">$user</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">User</span><span class="p">();</span>
        <span class="nv">$user</span><span class="o">-&gt;</span><span class="na">setName</span><span class="p">(</span><span class="s1">'Jonathan H. Wage'</span><span class="p">);</span>

        <span class="nv">$dm</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine.odm.mongodb.document_manager'</span><span class="p">);</span>
        <span class="nv">$dm</span><span class="o">-&gt;</span><span class="na">persist</span><span class="p">(</span><span class="nv">$user</span><span class="p">);</span>
        <span class="nv">$dm</span><span class="o">-&gt;</span><span class="na">flush</span><span class="p">();</span>

        <span class="c1">// ...</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">editAction</span><span class="p">(</span><span class="nv">$id</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$dm</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine.odm.mongodb.document_manager'</span><span class="p">);</span>
        <span class="nv">$user</span> <span class="o">=</span> <span class="nv">$dm</span><span class="o">-&gt;</span><span class="na">createQuery</span><span class="p">(</span><span class="s1">'find all from AcmeHelloBundle:User where id = ?'</span><span class="p">,</span> <span class="nv">$id</span><span class="p">);</span>
        <span class="nv">$user</span><span class="o">-&gt;</span><span class="na">setBody</span><span class="p">(</span><span class="s1">'new body'</span><span class="p">);</span>
        <span class="nv">$dm</span><span class="o">-&gt;</span><span class="na">flush</span><span class="p">();</span>

        <span class="c1">// ...</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">deleteAction</span><span class="p">(</span><span class="nv">$id</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$dm</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine.odm.mongodb.document_manager'</span><span class="p">);</span>
        <span class="nv">$user</span> <span class="o">=</span> <span class="nv">$dm</span><span class="o">-&gt;</span><span class="na">createQuery</span><span class="p">(</span><span class="s1">'find all from AcmeHelloBundle:User where id = ?'</span><span class="p">,</span> <span class="nv">$id</span><span class="p">);</span>
        <span class="nv">$dm</span><span class="o">-&gt;</span><span class="na">remove</span><span class="p">(</span><span class="nv">$user</span><span class="p">);</span>
        <span class="nv">$dm</span><span class="o">-&gt;</span><span class="na">flush</span><span class="p">();</span>

        <span class="c1">// ...</span>
    <span class="p">}</span>
<span class="p">}</span>
	</pre></div>
      </div>
      <div class="section" id="configuration">
	<span id="index-1"></span><h2>Configuration<a class="headerlink" href="#configuration" title="Permalink to this headline">¶</a></h2>
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
	<div class="section" id="registering-event-listeners-and-subscribers">
	  <h3>Registering Event Listeners and Subscribers<a class="headerlink" href="#registering-event-listeners-and-subscribers" title="Permalink to this headline">¶</a></h3>
	  <p>Doctrine uses the lightweight <tt class="docutils literal"><span class="pre">Doctrine\Common\EventManager</span></tt> class to trigger
	    a number of different events which you can hook into. You can register Event
	    Listeners or Subscribers by tagging the respective services with
	    <tt class="docutils literal"><span class="pre">doctrine.odm.mongodb.&lt;connection&gt;_event_listener</span></tt> or
	    <tt class="docutils literal"><span class="pre">doctrine.odm.mongodb.&lt;connection&gt;_event_subscriber</span></tt> using the Dependency Injection
	    container.</p>
	  <p>You have to use the name of the MongoDB connection to clearly identify which
	    connection the listeners should be registered with. If you are using multiple
	    connections you can hook different events into each connection.</p>
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
      </div>
      <div class="section" id="writing-document-classes">
	<h2>Writing Document Classes<a class="headerlink" href="#writing-document-classes" title="Permalink to this headline">¶</a></h2>
	<p>You can start writing document classes just how you normally would write some
	  PHP classes. The only difference is that you must map the classes to the
	  MongoDB ODM. You can provide the mapping information via xml, yaml or
	  annotations. In this example, for simplicity and ease of reading we will use
	  annotations.</p>
	<p>First, let's write a simple User class.</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Document/User.php</span>

<span class="k">namespace</span> <span class="nx">Acme\HelloBundle\Document</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">User</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$id</span><span class="p">;</span>
    <span class="k">protected</span> <span class="nv">$name</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">getId</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">id</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">setName</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">name</span> <span class="o">=</span> <span class="nv">$name</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">getName</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">name</span><span class="p">;</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>This class can be used independent from any persistence layer as it is a
	  regular PHP class and does not have any dependencies. Now we need to annotate
	  the class so Doctrine can read the annotated mapping information from the doc
	  blocks.</p>
	<div class="highlight-php-annotations"><div class="highlight"><pre><span class="c1">// ...</span>

<span class="sd">/** @mongodb:Document(collection="users") */</span>
<span class="k">class</span> <span class="nc">User</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @mongodb:Id</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$id</span><span class="p">;</span>

    <span class="sd">/**</span>
<span class="sd">     * @mongodb:Field(type="string")</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$name</span><span class="p">;</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	  </pre></div>
	</div>
      </div>
      <div class="section" id="using-documents">
	<h2>Using Documents<a class="headerlink" href="#using-documents" title="Permalink to this headline">¶</a></h2>
	<p>Now that you have a PHP class that has been mapped properly you can begin
	  working with instances of that document persisting to and retrieving from
	  MongoDB.</p>
	<p>From your controllers you can access the <tt class="docutils literal"><span class="pre">DocumentManager</span></tt> instance from the
	  container.</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">class</span> <span class="nc">UserController</span> <span class="k">extends</span> <span class="nx">Controller</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">createAction</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="nv">$user</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">User</span><span class="p">();</span>
        <span class="nv">$user</span><span class="o">-&gt;</span><span class="na">setName</span><span class="p">(</span><span class="s1">'Jonathan H. Wage'</span><span class="p">);</span>

        <span class="nv">$dm</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine.odm.mongodb.document_manager'</span><span class="p">);</span>
        <span class="nv">$dm</span><span class="o">-&gt;</span><span class="na">persist</span><span class="p">(</span><span class="nv">$user</span><span class="p">);</span>
        <span class="nv">$dm</span><span class="o">-&gt;</span><span class="na">flush</span><span class="p">();</span>

        <span class="c1">// ...</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>Later you can retrieve the persisted document by its id.</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">class</span> <span class="nc">UserController</span> <span class="k">extends</span> <span class="nx">Controller</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">editAction</span><span class="p">(</span><span class="nv">$id</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$dm</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine.odm.mongodb.document_manager'</span><span class="p">);</span>
        <span class="nv">$user</span> <span class="o">=</span> <span class="nv">$dm</span><span class="o">-&gt;</span><span class="na">find</span><span class="p">(</span><span class="s1">'AcmeHelloBundle:User'</span><span class="p">,</span> <span class="nv">$id</span><span class="p">);</span>

        <span class="c1">// ...</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<div class="section" id="id1">
	  <h3>Registering Event Listeners and Subscribers<a class="headerlink" href="#id1" title="Permalink to this headline">¶</a></h3>
	  <p>Registering events works like described in the <a class="reference internal" href="event_listeners_subscribers.html#doctrine-event-config"><em>ORM Bundle documentation</em></a>.
	    The MongoDB event tags are called "doctrine.odm.mongodb.default_event_listener" and
	    "doctrine.odm.mongodb.default_event_subscriber" respectively where "default" is the name of the
	    MongoDB document manager.</p>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to create Fixtures in Symfony2" href="doctrine_fixtures.html">
      «&nbsp;How to create Fixtures in Symfony2
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to use Doctrine Migrations" href="migrations.html">
      How to use Doctrine Migrations&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
