<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Databases and Doctrine ("The Model")</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="databases-and-doctrine-the-model">
      <span id="index-0"></span><h1>Databases and Doctrine ("The Model")<a class="headerlink" href="#databases-and-doctrine-the-model" title="Permalink to this headline">¶</a></h1>
      <p>Let's face it, one of the most common and challenging tasks for any application
	involves persisting and reading information to and from a database. Fortunately,
	Symfony comes integrated with <a class="reference external" href="http://www.doctrine-project.org/">Doctrine</a>, a library whose sole goal is to
	give you powerful tools to make this easy. In this chapter, you'll learn the
	basic philosophy behind Doctrine and see how easy working with a database can
	be.</p>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p>Doctrine is totally decoupled from Symfony and using it is optional.
	    This chapter is all about the Doctrine ORM, which aims to let you map
	    objects to a relational database (such as <em>MySQL</em>, <em>PostgreSQL</em> or <em>Microsoft SQL</em>).
	    If you prefer to use raw database queries, this is easy, and explained
	    in the "<a class="reference internal" href="../cookbook/doctrine/dbal.html"><em>How to use Doctrine's DBAL Layer</em></a>" cookbook entry.</p>
	  <p class="last">You can also persist data to <a class="reference external" href="http://www.mongodb.org/">MongoDB</a> using Doctrine ODM library. For
	    more information, read the "<a class="reference internal" href="../cookbook/doctrine/mongodb.html"><em>How to use MongoDB</em></a>" cookbook
	    entry.</p>
      </div></div>
      <div class="section" id="a-simple-example-a-product">
	<h2>A Simple Example: A Product<a class="headerlink" href="#a-simple-example-a-product" title="Permalink to this headline">¶</a></h2>
	<p>The easiest way to understand how Doctrine works is to see it in action.
	  In this section, you'll configure your database, create a <tt class="docutils literal"><span class="pre">Product</span></tt> object,
	  persist it to the database and fetch it back out.</p>
	<div class="admonition-wrapper">
	  <div class="sidebar"></div><div class="admonition admonition-sidebar"><p class="first sidebar-title">Code along with the example</p>
	    <p>If you want to follow along with the example in this chapter, create
	      an <tt class="docutils literal"><span class="pre">AcmeStoreBundle</span></tt> via:</p>
	    <div class="highlight-bash"><div class="highlight"><pre>php app/console init:bundle <span class="s2">"Acme\StoreBundle"</span> src/
	      </pre></div>
	    </div>
	    <p>Next, be sure that the new bundle is enabled in the kernel:</p>
	    <div class="last highlight-php"><div class="highlight"><pre><span class="c1">// app/AppKernel.php</span>

<span class="k">public</span> <span class="k">function</span> <span class="nf">registerBundles</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$bundles</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span>
        <span class="c1">// ...</span>
        <span class="k">new</span> <span class="nx">Acme\StoreBundle\AcmeStoreBundle</span><span class="p">(),</span>
    <span class="p">);</span>
<span class="p">}</span>
	      </pre></div>
	    </div>
	</div></div>
	<div class="section" id="configuring-the-database">
	  <h3>Configuring the Database<a class="headerlink" href="#configuring-the-database" title="Permalink to this headline">¶</a></h3>
	  <p>Before you really begin, you'll need to configure your database connection
	    information. By convention, this information is usually configured in an
	    <tt class="docutils literal"><span class="pre">app/config/parameters.ini</span></tt> file:</p>
	  <div class="highlight-ini"><div class="highlight"><pre><span class="c">;app/config/parameters.ini</span>
<span class="k">[parameters]</span>
    <span class="na">database_driver</span>   <span class="o">=</span> <span class="s">pdo_mysql</span>
<span class="s">    database_host     = localhost</span>
<span class="s">    database_name     = test_project</span>
<span class="s">    database_user     = root</span>
<span class="s">    database_password = password</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p>Defining the configuration via <tt class="docutils literal"><span class="pre">parameters.ini</span></tt> is just a convention.
		The parameters defined in that file are referenced by the main configuration
		file when setting up Doctrine:</p>
	      <div class="highlight-yaml"><pre>doctrine:
    dbal:
        driver:   %database_driver%
        host:     %database_host%
        dbname:   %database_name%
        user:     %database_user%
		  password: %database_password%</pre>
	      </div>
	      <p class="last">By separating the database information into a separate file, you can
		easily keep different version of the file on each server. You can also
		easily store database configuration (or any sensitive information) outside
		of your project, like inside your Apache configuration, for example. For
		more information, see <a class="reference internal" href="../cookbook/configuration/external_parameters.html"><em>How to Set External Parameters in the Service Container</em></a>.</p>
	  </div></div>
	  <p>Now that Doctrine knows about your database, you can have it create the database
	    for you:</p>
	  <div class="highlight-bash"><div class="highlight"><pre>php app/console doctrine:database:create
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="creating-an-entity-class">
	  <h3>Creating an Entity Class<a class="headerlink" href="#creating-an-entity-class" title="Permalink to this headline">¶</a></h3>
	  <p>Suppose you're building an application where products need to be displayed.
	    Without even thinking about Doctrine or databases, you already know that
	    you need a <tt class="docutils literal"><span class="pre">Product</span></tt> object to represent those products. Create this class
	    inside the <tt class="docutils literal"><span class="pre">Entity</span></tt> directory of your <tt class="docutils literal"><span class="pre">AcmeStoreBundle</span></tt>:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/StoreBundle/Entity/Product.php</span>
<span class="k">namespace</span> <span class="nx">Acme\StoreBundle\Entity</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Product</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$name</span><span class="p">;</span>

    <span class="k">protected</span> <span class="nv">$price</span><span class="p">;</span>

    <span class="k">protected</span> <span class="nv">$description</span><span class="p">;</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>The class - often called an "entity", meaning <em>a basic class that holds data</em>
	    - is simple and helps fulfill the business requirement of needing products
	    in your application. This class can't be persisted to a database yet - it's
	    just a simple PHP class.</p>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p>Once you learn the concepts behind Doctrine, you can have Doctrine create
		this entity class for you:</p>
	      <div class="last highlight-bash"><div class="highlight"><pre>php app/console doctrine:generate:entity AcmeStoreBundle:Product <span class="s2">"name:string(255) price:float description:text"</span>
		</pre></div>
	      </div>
	  </div></div>
	</div>
	<div class="section" id="add-mapping-information">
	  <h3>2) Add Mapping Information<a class="headerlink" href="#add-mapping-information" title="Permalink to this headline">¶</a></h3>
	  <p>Doctrine allows you to work with databases in a much more interesting way
	    than just fetching rows of column-based table into an array. Instead, Doctrine
	    allows you to persist entire <em>objects</em> to the database and fetch entire objects
	    out of the database. This works by mapping a PHP class to a database table,
	    and the properties of that PHP class to columns on the table:</p>
	  <img alt="../_images/doctrine_image_1.png" class="align-center" src="../_images/doctrine_image_1.png">
	  <p>For Doctrine to be able to do this, you just have to create "metadata", or
	    configuration that tells Doctrine exactly how the <tt class="docutils literal"><span class="pre">Product</span></tt> class and its
	    properties should be <em>mapped</em> to the database. This metadata can be specified
	    in a number of different formats including YAML, XML or directly inside the
	    <tt class="docutils literal"><span class="pre">Product</span></tt> class via annotations:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 652px; ">
	      <li class="selected"><em><a href="#">Annotations</a></em><div class="highlight-php-annotations" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1">// src/Acme/StoreBundle/Entity/Product.php</span>
<span class="k">namespace</span> <span class="nx">Acme\StoreBundle\Entity</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Doctrine\ORM\Mapping</span> <span class="k">as</span> <span class="nx">ORM</span><span class="p">;</span>

<span class="sd">/**</span>
<span class="sd"> * @ORM\Entity</span>
<span class="sd"> * @ORM\Table(name="product")</span>
<span class="sd"> */</span>
<span class="k">class</span> <span class="nc">Product</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @ORM\Id</span>
<span class="sd">     * @ORM\Column(type="integer")</span>
<span class="sd">     * @ORM\GeneratedValue(strategy="AUTO")</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$id</span><span class="p">;</span>

    <span class="sd">/**</span>
<span class="sd">     * @ORM\Column(type="string", length="100")</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$name</span><span class="p">;</span>

    <span class="sd">/**</span>
<span class="sd">     * @ORM\Column(type="decimal", scale="2")</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$price</span><span class="p">;</span>

    <span class="sd">/**</span>
<span class="sd">     * @ORM\Column(type="text")</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$description</span><span class="p">;</span>
<span class="p">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">YAML</a></em><div class="highlight-yaml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1"># src/Acme/StoreBundle/Resources/config/doctrine/Product.orm.yml</span>
<span class="l-Scalar-Plain">Acme\StoreBundle\Entity\Product</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">type</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">entity</span>
    <span class="l-Scalar-Plain">table</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">product</span>
    <span class="l-Scalar-Plain">id</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">id</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">type</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">integer</span>
            <span class="l-Scalar-Plain">generator</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">strategy</span><span class="p-Indicator">:</span> <span class="nv">AUTO</span> <span class="p-Indicator">}</span>
    <span class="l-Scalar-Plain">fields</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">name</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">type</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">string</span>
            <span class="l-Scalar-Plain">length</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">100</span>
        <span class="l-Scalar-Plain">price</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">type</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">decimal</span>
            <span class="l-Scalar-Plain">scale</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">2</span>
        <span class="l-Scalar-Plain">description</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">type</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">text</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/StoreBundle/Resources/config/doctrine/Product.orm.xml --&gt;</span>
<span class="nt">&lt;doctrine-mapping</span> <span class="na">xmlns=</span><span class="s">"http://doctrine-project.org/schemas/orm/doctrine-mapping"</span>
      <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
      <span class="na">xsi:schemaLocation=</span><span class="s">"http://doctrine-project.org/schemas/orm/doctrine-mapping</span>
<span class="s">                    http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;entity</span> <span class="na">name=</span><span class="s">"Acme\StoreBundle\Entity\Product"</span> <span class="na">table=</span><span class="s">"product"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;id</span> <span class="na">name=</span><span class="s">"id"</span> <span class="na">type=</span><span class="s">"integer"</span> <span class="na">column=</span><span class="s">"id"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;generator</span> <span class="na">strategy=</span><span class="s">"AUTO"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;/id&gt;</span>
        <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">"name"</span> <span class="na">column=</span><span class="s">"name"</span> <span class="na">type=</span><span class="s">"string"</span> <span class="na">length=</span><span class="s">"100"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">"price"</span> <span class="na">column=</span><span class="s">"price"</span> <span class="na">type=</span><span class="s">"decimal"</span> <span class="na">scale=</span><span class="s">"2"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">"description"</span> <span class="na">column=</span><span class="s">"description"</span> <span class="na">type=</span><span class="s">"text"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/entity&gt;</span>
<span class="nt">&lt;/doctrine-mapping&gt;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">The table option is optional and if omitted, will be determined automatically
		based on the name of the entity class.</p>
	  </div></div>
	  <p>Doctrine allows you to choose from a wide variety of different field types,
	    each with their own options. For information on the available field types,
	    see the <a class="reference internal" href="#book-doctrine-field-types"><em>Doctrine Field Types Reference</em></a> section.</p>
	  <div class="admonition-see-also admonition-wrapper">
	    <div class="seealso"></div><div class="admonition admonition-seealso"><p class="first admonition-title">See also</p>
	      <p class="last">You can also check out Doctrine's <a class="reference external" href="http://www.doctrine-project.org/docs/orm/2.0/en/reference/basic-mapping.html">Basic Mapping Documentation</a> for
		all details about mapping information. If you use annotations, you'll
		need to prepend all annotations with <tt class="docutils literal"><span class="pre">ORM\</span></tt> (e.g. <tt class="docutils literal"><span class="pre">ORM\Column(..)</span></tt>),
		which is not shown in Doctrine's documentation. You'll also need to include
		the <tt class="docutils literal"><span class="pre">use</span> <span class="pre">Doctrine\ORM\Mapping</span> <span class="pre">as</span> <span class="pre">ORM;</span></tt> statement, which <em>imports</em> the
		<tt class="docutils literal"><span class="pre">ORM</span></tt> annotations prefix.</p>
	  </div></div>
	</div>
	<div class="section" id="generating-getters-and-setters">
	  <h3>Generating Getters and Setters<a class="headerlink" href="#generating-getters-and-setters" title="Permalink to this headline">¶</a></h3>
	  <p>Even though Doctrine now knows how to persist a <tt class="docutils literal"><span class="pre">Product</span></tt> object to the
	    database, the class itself isn't really useful yet. Since <tt class="docutils literal"><span class="pre">Product</span></tt> is just
	    a regular PHP class, you need to create getter and setter methods (e.g. <tt class="docutils literal"><span class="pre">getName()</span></tt>,
	    <tt class="docutils literal"><span class="pre">setName()</span></tt>) in order to access its properties (since the properties are
	    <tt class="docutils literal"><span class="pre">protected</span></tt>). Fortunately, Doctrine can do this for you by running:</p>
	  <div class="highlight-bash"><div class="highlight"><pre>php app/console doctrine:generate:entities Acme/StoreBundle/Entity/Product
	    </pre></div>
	  </div>
	  <p>This command makes sure that all of the getters and setters are generated
	    for the <tt class="docutils literal"><span class="pre">Product</span></tt> class. This is a safe command - you can run it over and
	    over again: it only generates getters and setters that don't exist (i.e. it
	    doesn't replace your existing methods).</p>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">Doctrine doesn't care whether your properties are <tt class="docutils literal"><span class="pre">public</span></tt>, <tt class="docutils literal"><span class="pre">protected</span></tt>
		or <tt class="docutils literal"><span class="pre">private</span></tt>, or whether or not you have a getter or setter function
		for a property. The getters and setters are generated here only because
		you'll need them to interact with your PHP object.</p>
	  </div></div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p>You can also generate all known entities (i.e. any PHP class with Doctrine
		mapping information) of a bundle or an entire namespace:</p>
	      <div class="last highlight-bash"><div class="highlight"><pre>php app/console doctrine:generate:entities AcmeStoreBundle
php app/console doctrine:generate:entities Acme
		</pre></div>
	      </div>
	  </div></div>
	</div>
	<div class="section" id="creating-the-database-tables-schema">
	  <h3>Creating the Database Tables/Schema<a class="headerlink" href="#creating-the-database-tables-schema" title="Permalink to this headline">¶</a></h3>
	  <p>You now have a usable <tt class="docutils literal"><span class="pre">Product</span></tt> class with mapping information so that
	    Doctrine knows exactly how to persist it. Of course, you don't yet have the
	    corresponding <tt class="docutils literal"><span class="pre">product</span></tt> table in your database. Fortunately, Doctrine can
	    automatically create all the database tables needed for every known entity
	    in your application. To do this, run:</p>
	  <div class="highlight-bash"><div class="highlight"><pre>php app/console doctrine:schema:update --force
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p>Actually, this command is incredibly powerful. It compares what
		your database <em>should</em> look like (based on the mapping information of
		your entities) with how it <em>actually</em> looks, and generates the SQL statements
		needed to <em>update</em> the database to where it should be. In other words, if you add
		a new property with mapping metadata to <tt class="docutils literal"><span class="pre">Product</span></tt> and run this task
		again, it will generate the "alter table" statement needed to add that
		new column to the existing <tt class="docutils literal"><span class="pre">products</span></tt> table.</p>
	      <p class="last">An even better way to take advantage of this functionality is via
		<a class="reference internal" href="../cookbook/doctrine/migrations.html"><em>migrations</em></a>, which allow you to
		generate these SQL statements and store them in migration classes that
		can be run systematically on your production server in order to track
		and migrate your database schema safely and reliably.</p>
	  </div></div>
	  <p>Your database now has a fully-functional <tt class="docutils literal"><span class="pre">product</span></tt> table with columns that
	    match the metadata you've specified.</p>
	</div>
	<div class="section" id="persisting-objects-to-the-database">
	  <h3>Persisting Objects to the Database<a class="headerlink" href="#persisting-objects-to-the-database" title="Permalink to this headline">¶</a></h3>
	  <p>Now that you have a mapped <tt class="docutils literal"><span class="pre">Product</span></tt> entity and corresponding <tt class="docutils literal"><span class="pre">product</span></tt>
	    table, you're ready to persist data to the database. From inside a controller,
	    this is pretty easy. Add the following method to the <tt class="docutils literal"><span class="pre">DefaultController</span></tt>
	    of the bundle:</p>
	  <div class="highlight-php"><table class="highlighttable"><tbody><tr><td class="linenos"><div class="linenodiv"><pre> 1
 2
 3
 4
 5
 6
 7
 8
 9
10
11
12
13
14
15
16
			17</pre></div></td><td class="code"><div class="highlight"><pre><span class="c1">// src/Acme/StoreBundle/Controller/DefaultController.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Response</span><span class="p">;</span>
<span class="c1">// ...</span>

<span class="k">public</span> <span class="k">function</span> <span class="nf">createAction</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$product</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Product</span><span class="p">();</span>
    <span class="nv">$product</span><span class="o">-&gt;</span><span class="na">setName</span><span class="p">(</span><span class="s1">'A Foo Bar'</span><span class="p">);</span>
    <span class="nv">$product</span><span class="o">-&gt;</span><span class="na">setPrice</span><span class="p">(</span><span class="s1">'19.99'</span><span class="p">);</span>
    <span class="nv">$product</span><span class="o">-&gt;</span><span class="na">setDescription</span><span class="p">(</span><span class="s1">'Lorem ipsum dolor'</span><span class="p">);</span>

    <span class="nv">$em</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">getEntityManager</span><span class="p">();</span>
    <span class="nv">$em</span><span class="o">-&gt;</span><span class="na">persist</span><span class="p">(</span><span class="nv">$product</span><span class="p">);</span>
    <span class="nv">$em</span><span class="o">-&gt;</span><span class="na">flush</span><span class="p">();</span>

    <span class="k">return</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="s1">'Created product id '</span><span class="o">.</span><span class="nv">$product</span><span class="o">-&gt;</span><span class="na">getId</span><span class="p">());</span>
<span class="p">}</span>
		    </pre></div>
	  </td></tr></tbody></table></div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">If you're following along with this example, you'll need to create a
		route that points to this action to see it in work.</p>
	  </div></div>
	  <p>Let's walk through this example:</p>
	  <ul class="simple">
	    <li><strong>lines 5-8</strong> In this section, you instantiate and work with the <tt class="docutils literal"><span class="pre">$product</span></tt>
	      object like any other, normal PHP object;</li>
	    <li><strong>line 10</strong> This line fetches Doctrine's <em>entity manager</em> object, which is
	      responsibly for handling the process of persisting and fetching objects
	      to and from the database;</li>
	    <li><strong>line 11</strong> The <tt class="docutils literal"><span class="pre">persist()</span></tt> method tells Doctrine to "manage" the <tt class="docutils literal"><span class="pre">$product</span></tt>
	      object. This does not actually cause a query to be made to the database (yet).</li>
	    <li><strong>line 12</strong> When the <tt class="docutils literal"><span class="pre">flush()</span></tt> method is called, Doctrine looks through
	      all of the objects that it's managing to see if they need to be persisted
	      to the database. In this example, the <tt class="docutils literal"><span class="pre">$product</span></tt> object has not been
	      persisted yet, so the entity manager executes an <tt class="docutils literal"><span class="pre">INSERT</span></tt> query and a
	      row is created in the <tt class="docutils literal"><span class="pre">product</span></tt> table.</li>
	  </ul>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">In fact, since Doctrine is aware of all your managed entities, when you
		call the <tt class="docutils literal"><span class="pre">flush()</span></tt> method, it calculates an overall changeset and executes
		the most efficient query/queries possible. For example, if you're persist
		100 <tt class="docutils literal"><span class="pre">Product</span></tt> objects and then call <tt class="docutils literal"><span class="pre">persist()</span></tt>, Doctrine will create
		a <em>single</em> prepared statement and re-use it for each insert. This pattern
		is called <em>Unit of Work</em>, and it's used because it's fast and efficient.</p>
	  </div></div>
	  <p>When creating or updating objects, the workflow is always the same. In the
	    next section, you'll see how Doctrine is smart enough to automatically issue
	    an <tt class="docutils literal"><span class="pre">UPDATE</span></tt> query if the record already exists in the database.</p>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">Doctrine provides a library that allows you to programmatically load testing
		data into your project (i.e. "fixture data"). For information, see
		<a class="reference internal" href="../cookbook/doctrine/doctrine_fixtures.html"><em>How to create Fixtures in Symfony2</em></a>.</p>
	  </div></div>
	</div>
	<div class="section" id="fetching-objects-from-the-database">
	  <h3>Fetching Objects from the Database<a class="headerlink" href="#fetching-objects-from-the-database" title="Permalink to this headline">¶</a></h3>
	  <p>Fetching an object back out of the database is even easier. For example,
	    suppose you've configured a route to display a specific <tt class="docutils literal"><span class="pre">Product</span></tt> based
	    on its <tt class="docutils literal"><span class="pre">id</span></tt> value:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">showAction</span><span class="p">(</span><span class="nv">$id</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$product</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">)</span>
        <span class="o">-&gt;</span><span class="na">getEntityManager</span><span class="p">()</span>
        <span class="o">-&gt;</span><span class="na">getRepository</span><span class="p">(</span><span class="s1">'AcmeStoreBundle:Product'</span><span class="p">)</span>
        <span class="o">-&gt;</span><span class="na">find</span><span class="p">(</span><span class="nv">$id</span><span class="p">);</span>

    <span class="k">if</span> <span class="p">(</span><span class="o">!</span><span class="nv">$product</span><span class="p">)</span> <span class="p">{</span>
        <span class="k">throw</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">createNotFoundException</span><span class="p">(</span><span class="s1">'No product found for id '</span><span class="o">.</span><span class="nv">$id</span><span class="p">);</span>
    <span class="p">}</span>

    <span class="c1">// do something, like pass the $product object into a template</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>When you query for a particular type of object, you always use what's known
	    as its "repository". You can think of a repository as a PHP class whose only
	    job is to help you fetch entities of a certain class. You can access the
	    repository object for an entity class via:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$repository</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">)</span>
    <span class="o">-&gt;</span><span class="na">getEntityManager</span><span class="p">()</span>
    <span class="o">-&gt;</span><span class="na">getRepository</span><span class="p">(</span><span class="s1">'AcmeStoreBundle:Product'</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">The <tt class="docutils literal"><span class="pre">AcmeStoreBundle:Product</span></tt> string is a shortcut you can use anywhere
		in Doctrine instead of the full class name of the entity (i.e. <tt class="docutils literal"><span class="pre">Acme\StoreBundle\Entity\Product</span></tt>).
		As long as your entity lives under the <tt class="docutils literal"><span class="pre">Entity</span></tt> namespace of your bundle,
		this will work.</p>
	  </div></div>
	  <p>Once you have your repository, you have access to all sorts of helpful methods:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// query by the primary key (usually "id")</span>
<span class="nv">$product</span> <span class="o">=</span> <span class="nv">$repository</span><span class="o">-&gt;</span><span class="na">find</span><span class="p">(</span><span class="nv">$id</span><span class="p">);</span>

<span class="c1">// dynamic method names to find based on a column value</span>
<span class="nv">$product</span> <span class="o">=</span> <span class="nv">$repository</span><span class="o">-&gt;</span><span class="na">findOneById</span><span class="p">(</span><span class="nv">$id</span><span class="p">);</span>
<span class="nv">$product</span> <span class="o">=</span> <span class="nv">$repository</span><span class="o">-&gt;</span><span class="na">findOneByName</span><span class="p">(</span><span class="s1">'foo'</span><span class="p">);</span>

<span class="c1">// find *all* products</span>
<span class="nv">$products</span> <span class="o">=</span> <span class="nv">$repository</span><span class="o">-&gt;</span><span class="na">findAll</span><span class="p">();</span>

<span class="c1">// find a group of products based on an abitrary column value</span>
<span class="nv">$products</span> <span class="o">=</span> <span class="nv">$repository</span><span class="o">-&gt;</span><span class="na">findByPrice</span><span class="p">(</span><span class="mf">19.99</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">Of course, you can also issue complex queries, which you'll learn more
		about in the <a class="reference internal" href="#book-doctrine-queries"><em>Querying for Objects</em></a> section.</p>
	  </div></div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p>When you render any page, you can see how many queries were made in the
		bottom right corner of the web debug toolbar.</p>
	      <a class="reference internal image-reference" href="../_images/doctrine_web_debug_toolbar.png"><img alt="../_images/doctrine_web_debug_toolbar.png" class="align-center" src="../_images/doctrine_web_debug_toolbar.png" style="width: 175.0px;"></a>
	      <p class="last">If you click the icon, the profiler will open, showing you the exact
		queries that were made.</p>
	  </div></div>
	</div>
	<div class="section" id="updating-an-object">
	  <h3>Updating an Object<a class="headerlink" href="#updating-an-object" title="Permalink to this headline">¶</a></h3>
	  <p>Once you've fetched an object from Doctrine, updating it is easy. Suppose
	    you have a route that maps a product id to an update action in a controller:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">updateAction</span><span class="p">(</span><span class="nv">$id</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$em</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">getEntityManager</span><span class="p">();</span>
    <span class="nv">$product</span> <span class="o">=</span> <span class="nv">$em</span><span class="o">-&gt;</span><span class="na">getRepository</span><span class="p">(</span><span class="s1">'AcmeStoreBundle:Product'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">find</span><span class="p">(</span><span class="nv">$id</span><span class="p">);</span>

    <span class="k">if</span> <span class="p">(</span><span class="o">!</span><span class="nv">$product</span><span class="p">)</span> <span class="p">{</span>
        <span class="k">throw</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">createNotFoundException</span><span class="p">(</span><span class="s1">'No product found for id '</span><span class="o">.</span><span class="nv">$id</span><span class="p">);</span>
    <span class="p">}</span>

    <span class="nv">$product</span><span class="o">-&gt;</span><span class="na">setName</span><span class="p">(</span><span class="s1">'New product name!'</span><span class="p">);</span>
    <span class="nv">$em</span><span class="o">-&gt;</span><span class="na">flush</span><span class="p">();</span>

    <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">redirect</span><span class="p">(</span><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">generateUrl</span><span class="p">(</span><span class="s1">'homepage'</span><span class="p">));</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>Updating an object involves just three steps:</p>
	  <ol class="arabic simple">
	    <li>fetching the object from Doctrine;</li>
	    <li>modifying the object;</li>
	    <li>calling <tt class="docutils literal"><span class="pre">flush()</span></tt> on the entity manager</li>
	  </ol>
	  <p>Notice that calling <tt class="docutils literal"><span class="pre">$em-&gt;persist($product)</span></tt> isn't necessary. Recall that
	    this method simply tells Doctrine to manage or "watch" the <tt class="docutils literal"><span class="pre">$product</span></tt> object.
	    In this case, since you fetched the <tt class="docutils literal"><span class="pre">$product</span></tt> object from Doctrine, it's
	    already managed.</p>
	</div>
	<div class="section" id="deleting-an-object">
	  <h3>Deleting an Object<a class="headerlink" href="#deleting-an-object" title="Permalink to this headline">¶</a></h3>
	  <p>Deleting an object is very similar, but requires a call to the <tt class="docutils literal"><span class="pre">remove()</span></tt>
	    method of the entity manager:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$em</span><span class="o">-&gt;</span><span class="na">remove</span><span class="p">(</span><span class="nv">$product</span><span class="p">);</span>
<span class="nv">$em</span><span class="o">-&gt;</span><span class="na">flush</span><span class="p">();</span>
	    </pre></div>
	  </div>
	  <p>As you might expect, the <tt class="docutils literal"><span class="pre">remove()</span></tt> method notifies Doctrine that you'd
	    like to remove the given entity from the database. The actual <tt class="docutils literal"><span class="pre">DELETE</span></tt> query,
	    however, isn't actually executed until the <tt class="docutils literal"><span class="pre">flush()</span></tt> method is called.</p>
	</div>
      </div>
      <div class="section" id="querying-for-objects">
	<span id="book-doctrine-queries"></span><h2>Querying for Objects<a class="headerlink" href="#querying-for-objects" title="Permalink to this headline">¶</a></h2>
	<p>You've already seen how the repository object allows you to run basic queries
	  without any work:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$repository</span><span class="o">-&gt;</span><span class="na">find</span><span class="p">(</span><span class="nv">$id</span><span class="p">);</span>

<span class="nv">$repository</span><span class="o">-&gt;</span><span class="na">findOneByName</span><span class="p">(</span><span class="s1">'Foo'</span><span class="p">);</span>
	  </pre></div>
	</div>
	<p>Of course, Doctrine also allows you to write more complex queries using the
	  Doctrine Query Language (DQL). DQL is similar to SQL except that you should
	  imagine that you're querying for one or more objects of an entity class (e.g. <tt class="docutils literal"><span class="pre">Product</span></tt>)
	  instead of querying for rows on a table (e.g. <tt class="docutils literal"><span class="pre">product</span></tt>).</p>
	<p>When querying in Doctrine, you have two options: writing pure Doctrine queries
	  or using Doctrine's Query Builder.</p>
	<div class="section" id="querying-for-objects-with-dql">
	  <h3>Querying for Objects with DQL<a class="headerlink" href="#querying-for-objects-with-dql" title="Permalink to this headline">¶</a></h3>
	  <p>Imaging that you want to query for products, but only return products that
	    cost more than <tt class="docutils literal"><span class="pre">19.99</span></tt>, ordered from cheapest to most expensive. From inside
	    a controller, do the following:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$em</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">getEntityManager</span><span class="p">();</span>
<span class="nv">$query</span> <span class="o">=</span> <span class="nv">$em</span><span class="o">-&gt;</span><span class="na">createQuery</span><span class="p">(</span>
    <span class="s1">'SELECT p FROM AcmeStoreBundle:Product p WHERE p.price &gt; :price ORDER BY p.price ASC'</span>
<span class="p">)</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'price'</span><span class="p">,</span> <span class="s1">'19.99'</span><span class="p">);</span>

<span class="nv">$products</span> <span class="o">=</span> <span class="nv">$query</span><span class="o">-&gt;</span><span class="na">getResult</span><span class="p">();</span>
	    </pre></div>
	  </div>
	  <p>If you're comfortable with SQL, then DQL should feel very natural. The biggest
	    difference is that you need to think in terms of "objects" instead of rows
	    in a database. For this reason, you select <em>from</em> <tt class="docutils literal"><span class="pre">AcmeStoreBundle:Product</span></tt>
	    and then alias it as <tt class="docutils literal"><span class="pre">p</span></tt>.</p>
	  <p>The <tt class="docutils literal"><span class="pre">getResult()</span></tt> method returns an array of results. If you're querying
	    for just one object, you can use the <tt class="docutils literal"><span class="pre">getSingleResult()</span></tt> method instead:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$product</span> <span class="o">=</span> <span class="nv">$query</span><span class="o">-&gt;</span><span class="na">getSingleResult</span><span class="p">();</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="caution"></div><div class="admonition admonition-caution"><p class="first admonition-title">Caution</p>
	      <p>The <tt class="docutils literal"><span class="pre">getSingleResult()</span></tt> method throws a <tt class="docutils literal"><span class="pre">Doctrine\ORM\NoResultException</span></tt>
		exception if no results are returned and a <tt class="docutils literal"><span class="pre">Doctrine\ORM\NonUniqueResultException</span></tt>
		if <em>more</em> than one result is returned. If you use this method, you may
		need to wrap it in a try-catch block and ensure that only one result is
		returned (if you're querying on something that could feasibly return
		more than one result):</p>
	      <div class="last highlight-php"><div class="highlight"><pre><span class="nv">$query</span> <span class="o">=</span> <span class="nv">$em</span><span class="o">-&gt;</span><span class="na">createQuery</span><span class="p">(</span><span class="s1">'SELECT ....'</span><span class="p">)</span>
    <span class="o">-&gt;</span><span class="na">setMaxResults</span><span class="p">(</span><span class="mi">1</span><span class="p">);</span>

<span class="k">try</span> <span class="p">{</span>
    <span class="nv">$product</span> <span class="o">=</span> <span class="nv">$query</span><span class="o">-&gt;</span><span class="na">getSingleResult</span><span class="p">();</span>
<span class="p">}</span> <span class="k">catch</span> <span class="p">(</span><span class="nx">\Doctrine\Orm\NoResultException</span> <span class="nv">$e</span><span class="p">)</span> <span class="p">{</span>
    <span class="nv">$product</span> <span class="o">=</span> <span class="k">null</span><span class="p">;</span>
<span class="p">}</span>
<span class="c1">// ...</span>
		</pre></div>
	      </div>
	  </div></div>
	  <p>The DQL syntax is incredibly powerful, allowing you to easily join between
	    entities (the topic of <a class="reference internal" href="#book-doctrine-relations"><em>relations</em></a> will be
	    covered later), group, etc. For more information, see the official Doctrine
	    <a class="reference external" href="http://www.doctrine-project.org/docs/orm/2.0/en/reference/dql-doctrine-query-language.html">Doctrine Query Language</a> documentation.</p>
	  <div class="admonition-wrapper">
	    <div class="sidebar"></div><div class="admonition admonition-sidebar"><p class="first sidebar-title">Setting Parameters</p>
	      <p>Take note of the <tt class="docutils literal"><span class="pre">setParameter()</span></tt> method. When working with Doctrine,
		it's always a good idea to set any external values as "placeholders",
		which was done in the above query:</p>
	      <div class="highlight-text"><div class="highlight"><pre>... WHERE p.price &gt; :price ...
		</pre></div>
	      </div>
	      <p>You can then set the value of the <tt class="docutils literal"><span class="pre">price</span></tt> placeholder by calling the
		<tt class="docutils literal"><span class="pre">setParameter()</span></tt> method:</p>
	      <div class="highlight-php"><div class="highlight"><pre><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'price'</span><span class="p">,</span> <span class="s1">'19.99'</span><span class="p">)</span>
		</pre></div>
	      </div>
	      <p>Using parameters instead of placing values directly in the query string
		is done to prevent SQL injection attacks and should <em>always</em> be done.
		If you're using multiple parameters, you can set their values at once
		using the <tt class="docutils literal"><span class="pre">setParameters()</span></tt> method:</p>
	      <div class="last highlight-php"><div class="highlight"><pre><span class="o">-&gt;</span><span class="na">setParameters</span><span class="p">(</span><span class="k">array</span><span class="p">(</span>
    <span class="s1">'price'</span> <span class="o">=&gt;</span> <span class="s1">'19.99'</span><span class="p">,</span>
    <span class="s1">'name'</span>  <span class="o">=&gt;</span> <span class="s1">'Foo'</span><span class="p">,</span>
<span class="p">))</span>
		</pre></div>
	      </div>
	  </div></div>
	</div>
	<div class="section" id="using-doctrine-s-query-builder">
	  <h3>Using Doctrine's Query Builder<a class="headerlink" href="#using-doctrine-s-query-builder" title="Permalink to this headline">¶</a></h3>
	  <p>Instead of writing the queries directly, you can alternatively use Doctrine's
	    <tt class="docutils literal"><span class="pre">QueryBuilder</span></tt> to do the same job using a nice, object-oriented interface.
	    If you use an IDE, you can also take advantage of auto-completion as you
	    type the method names. From inside a controller:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$repository</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">)</span>
    <span class="o">-&gt;</span><span class="na">getEntityManager</span><span class="p">()</span>
    <span class="o">-&gt;</span><span class="na">getRepository</span><span class="p">(</span><span class="s1">'AcmeStoreBundle:Product'</span><span class="p">);</span>

<span class="nv">$query</span> <span class="o">=</span> <span class="nv">$repository</span><span class="o">-&gt;</span><span class="na">createQueryBuilder</span><span class="p">(</span><span class="s1">'p'</span><span class="p">)</span>
    <span class="o">-&gt;</span><span class="na">where</span><span class="p">(</span><span class="s1">'p.price &gt; :price'</span><span class="p">)</span>
    <span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'price'</span><span class="p">,</span> <span class="s1">'19.99'</span><span class="p">)</span>
    <span class="o">-&gt;</span><span class="na">orderBy</span><span class="p">(</span><span class="s1">'p.price'</span><span class="p">,</span> <span class="s1">'ASC'</span><span class="p">)</span>
    <span class="o">-&gt;</span><span class="na">getQuery</span><span class="p">();</span>

<span class="nv">$products</span> <span class="o">=</span> <span class="nv">$query</span><span class="o">-&gt;</span><span class="na">getResult</span><span class="p">();</span>
	    </pre></div>
	  </div>
	  <p>The <tt class="docutils literal"><span class="pre">QueryBuilder</span></tt> object contains every method necessary to build your
	    query. By calling the <tt class="docutils literal"><span class="pre">getQuery()</span></tt> method, the query builder returns a
	    normal <tt class="docutils literal"><span class="pre">Query</span></tt> object, which is the same object you built directly in the
	    previous section.</p>
	  <p>For more information on Doctrine's Query Builder, consult Doctrine's
	    <a class="reference external" href="http://www.doctrine-project.org/docs/orm/2.0/en/reference/query-builder.html">Query Builder</a> documentation.</p>
	</div>
	<div class="section" id="custom-repository-classes">
	  <h3>Custom Repository Classes<a class="headerlink" href="#custom-repository-classes" title="Permalink to this headline">¶</a></h3>
	  <p>In the previous sections, you began constructing and using more complex queries
	    from inside a controller. In order to isolate, test and reuse these queries,
	    it's a good idea to create a custom repository class for your entity and
	    add methods with your query logic there.</p>
	  <p>To do this, add the name of the repository class to your mapping definition.</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 274px; ">
	      <li class="selected"><em><a href="#">Annotations</a></em><div class="highlight-php-annotations" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1">// src/Acme/StoreBundle/Entity/Product.php</span>
<span class="k">namespace</span> <span class="nx">Acme\StoreBundle\Entity</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Doctrine\ORM\Mapping</span> <span class="k">as</span> <span class="nx">ORM</span><span class="p">;</span>

<span class="sd">/**</span>
<span class="sd"> * @ORM\Entity(repositoryClass="Acme\StoreBundle\Repository\ProductRepository")</span>
<span class="sd"> */</span>
<span class="k">class</span> <span class="nc">Product</span>
<span class="p">{</span>
    <span class="c1">//...</span>
<span class="p">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">YAML</a></em><div class="highlight-yaml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1"># src/Acme/StoreBundle/Resources/config/doctrine/Product.orm.yml</span>
<span class="l-Scalar-Plain">Acme\StoreBundle\Entity\Product</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">type</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">entity</span>
    <span class="l-Scalar-Plain">repositoryClass</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Acme\StoreBundle\Repository\ProductRepository</span>
    <span class="c1"># ...</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/StoreBundle/Resources/config/doctrine/Product.orm.xml --&gt;</span>
<span class="c">&lt;!-- ... --&gt;</span>
<span class="nt">&lt;doctrine-mapping&gt;</span>

    <span class="nt">&lt;entity</span> <span class="na">name=</span><span class="s">"Acme\StoreBundle\Entity\Product"</span>
            <span class="na">repository-class=</span><span class="s">"Acme\StoreBundle\Repository\ProductRepository"</span><span class="nt">&gt;</span>
            <span class="c">&lt;!-- ... --&gt;</span>
    <span class="nt">&lt;/entity&gt;</span>
<span class="nt">&lt;/doctrine-mapping&gt;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>Doctrine can generate the repository class for you by running the same command
	    used earlier to generate the missing getter and setter methods:</p>
	  <div class="highlight-bash"><div class="highlight"><pre>php app/console doctrine:generate:entities Acme
	    </pre></div>
	  </div>
	  <p>Next, add a new method - <tt class="docutils literal"><span class="pre">findAllOrderedByName()</span></tt> - to the newly generated
	    repository class. This method will query for all of the <tt class="docutils literal"><span class="pre">Product</span></tt> entities,
	    ordered alphabetically.</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/StoreBundle/Repository/ProductRepository.php</span>
<span class="k">namespace</span> <span class="nx">Acme\StoreBundle\Repository</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Doctrine\ORM\EntityRepository</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">ProductRepository</span> <span class="k">extends</span> <span class="nx">EntityRepository</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">findAllOrderedByName</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">getEntityManager</span><span class="p">()</span>
            <span class="o">-&gt;</span><span class="na">createQuery</span><span class="p">(</span><span class="s1">'SELECT p FROM AcmeStoreBundle:Product p ORDER BY p.name ASC'</span><span class="p">)</span>
            <span class="o">-&gt;</span><span class="na">getResult</span><span class="p">();</span>
    <span class="p">}</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">The entity manager can be accessed via <tt class="docutils literal"><span class="pre">$this-&gt;getEntityManager()</span></tt>
		from inside the repository.</p>
	  </div></div>
	  <p>You can use this new method just like the default finder methods of the repository:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$em</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">getEntityManager</span><span class="p">();</span>
<span class="nv">$products</span> <span class="o">=</span> <span class="nv">$em</span><span class="o">-&gt;</span><span class="na">getRepository</span><span class="p">(</span><span class="s1">'AcmeStoreBundle:Product'</span><span class="p">)</span>
            <span class="o">-&gt;</span><span class="na">findAllOrderedByName</span><span class="p">();</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">When using a custom repository class, you still have access to the default
		finder methods such as <tt class="docutils literal"><span class="pre">find()</span></tt> and <tt class="docutils literal"><span class="pre">findAll()</span></tt>.</p>
	  </div></div>
	</div>
      </div>
      <div class="section" id="entity-relationships-associations">
	<span id="book-doctrine-relations"></span><h2>Entity Relationships/Associations<a class="headerlink" href="#entity-relationships-associations" title="Permalink to this headline">¶</a></h2>
	<p>Suppose that the products in your application all belong to exactly one "category".
	  In this case, you'll need a <tt class="docutils literal"><span class="pre">Category</span></tt> object and a way to relate a <tt class="docutils literal"><span class="pre">Product</span></tt>
	  object to a <tt class="docutils literal"><span class="pre">Category</span></tt> object. Start by creating the <tt class="docutils literal"><span class="pre">Category</span></tt> entity.
	  Since you know that you'll eventually need to persist the class through Doctrine,
	  you can let Doctrine create the class for you:</p>
	<div class="highlight-bash"><div class="highlight"><pre>php app/console doctrine:generate:entity AcmeStoreBundle:Category <span class="s2">"name:string(255)"</span> --mapping-type<span class="o">=</span>yml
	  </pre></div>
	</div>
	<p>This task generates the <tt class="docutils literal"><span class="pre">Category</span></tt> entity for you, with an <tt class="docutils literal"><span class="pre">id</span></tt> field,
	  a <tt class="docutils literal"><span class="pre">name</span></tt> field and the associated getter and setter functions.</p>
	<div class="section" id="relationship-mapping-metadata">
	  <h3>Relationship Mapping Metadata<a class="headerlink" href="#relationship-mapping-metadata" title="Permalink to this headline">¶</a></h3>
	  <p>To relate the <tt class="docutils literal"><span class="pre">Category</span></tt> and <tt class="docutils literal"><span class="pre">Product</span></tt> entities, start by creating a
	    <tt class="docutils literal"><span class="pre">products</span></tt> property on the <tt class="docutils literal"><span class="pre">Category</span></tt> class:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/StoreBundle/Entity/Category.php</span>
<span class="c1">// ...</span>
<span class="k">use</span> <span class="nx">Doctrine\Common\Collections\ArrayCollection</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Category</span>
<span class="p">{</span>
    <span class="c1">// ...</span>

    <span class="sd">/**</span>
<span class="sd">     * @ORM\OneToMany(targetEntity="Product", mappedBy="category")</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$products</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">__construct</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">products</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">ArrayCollection</span><span class="p">();</span>
    <span class="p">}</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>First, since a <tt class="docutils literal"><span class="pre">Category</span></tt> object will relate to many <tt class="docutils literal"><span class="pre">Product</span></tt> objects,
	    a <tt class="docutils literal"><span class="pre">products</span></tt> array property is added to hold those <tt class="docutils literal"><span class="pre">Product</span></tt> objects.
	    Again, this isn't done because Doctrine needs it, but instead because it
	    makes sense in the application for each <tt class="docutils literal"><span class="pre">Category</span></tt> to hold an array of
	    <tt class="docutils literal"><span class="pre">Product</span></tt> objects.</p>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">The code in the <tt class="docutils literal"><span class="pre">__construct()</span></tt> method is important because Doctrine
		requires the <tt class="docutils literal"><span class="pre">$products</span></tt> property to be an <tt class="docutils literal"><span class="pre">ArrayCollection</span></tt> object.
		This object looks and acts almost <em>exactly</em> like an array, but has some
		added flexibility. If this makes you uncomfortable, don't worry. Just
		imagine that it's an <tt class="docutils literal"><span class="pre">array</span></tt> and you'll be in good shape.</p>
	  </div></div>
	  <p>Next, since each <tt class="docutils literal"><span class="pre">Product</span></tt> class can relate to exactly one <tt class="docutils literal"><span class="pre">Category</span></tt>
	    object, you'll want to add a <tt class="docutils literal"><span class="pre">$category</span></tt> property to the <tt class="docutils literal"><span class="pre">Product</span></tt> class:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/StoreBundle/Entity/Product.php</span>
<span class="c1">// ...</span>

<span class="k">class</span> <span class="nc">Product</span>
<span class="p">{</span>
    <span class="c1">// ...</span>

    <span class="sd">/**</span>
<span class="sd">     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")</span>
<span class="sd">     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$category</span><span class="p">;</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>Finally, now that you've added a new property to both the <tt class="docutils literal"><span class="pre">Category</span></tt> and
	    <tt class="docutils literal"><span class="pre">Product</span></tt> classes, tell Doctrine to generate the missing getter and setter
	    methods for you:</p>
	  <div class="highlight-bash"><div class="highlight"><pre>php app/console doctrine:generate:entities Acme
	    </pre></div>
	  </div>
	  <p>Ignore the Doctrine metadata for a moment. You now have two classes - <tt class="docutils literal"><span class="pre">Category</span></tt>
	    and <tt class="docutils literal"><span class="pre">Product</span></tt> with a natural one-to-many relationship. The <tt class="docutils literal"><span class="pre">Category</span></tt>
	    class holds an array of <tt class="docutils literal"><span class="pre">Product</span></tt> objects and the <tt class="docutils literal"><span class="pre">Product</span></tt> object can
	    hold one <tt class="docutils literal"><span class="pre">Category</span></tt> object. In other words - you've built your classes
	    in a way that makes sense for your needs. The fact that the data needs to
	    be persisted to a database is always secondary.</p>
	  <p>Now, look at the metadata above the <tt class="docutils literal"><span class="pre">$category</span></tt> property on the <tt class="docutils literal"><span class="pre">Product</span></tt>
	    class. The information here tells doctrine that the related class is <tt class="docutils literal"><span class="pre">Category</span></tt>
	    and that it should store the <tt class="docutils literal"><span class="pre">id</span></tt> of the category record on a <tt class="docutils literal"><span class="pre">category_id</span></tt>
	    field that lives on the <tt class="docutils literal"><span class="pre">product</span></tt> table. In other words, the related <tt class="docutils literal"><span class="pre">Category</span></tt>
	    object will be stored on the <tt class="docutils literal"><span class="pre">$category</span></tt> property, but behind the scenes,
	    Doctrine will persist this relationship by storing the category's id value
	    on a <tt class="docutils literal"><span class="pre">category_id</span></tt> column of the <tt class="docutils literal"><span class="pre">product</span></tt> table.</p>
	  <img alt="../_images/doctrine_image_2.png" class="align-center" src="../_images/doctrine_image_2.png">
	  <p>The metadata above the <tt class="docutils literal"><span class="pre">$products</span></tt> property of the <tt class="docutils literal"><span class="pre">Category</span></tt> object
	    is less important, and simply tells Doctrine to look at the <tt class="docutils literal"><span class="pre">Product.category</span></tt>
	    property to figure out how the relationship is mapped.</p>
	  <p>Before you continue, be sure to tell Doctrine to add the new <tt class="docutils literal"><span class="pre">category</span></tt>
	    table, and <tt class="docutils literal"><span class="pre">product.category_id</span></tt> column, and new foreign key:</p>
	  <div class="highlight-bash"><div class="highlight"><pre>php app/console doctrine:schema:update --force
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">This task should only be really used during development. For a more robust
		method of systematically updating your production database, read about
		<a class="reference internal" href="../cookbook/doctrine/migrations.html"><em>Doctrine migrations</em></a>.</p>
	  </div></div>
	</div>
	<div class="section" id="saving-related-entities">
	  <h3>Saving Related Entities<a class="headerlink" href="#saving-related-entities" title="Permalink to this headline">¶</a></h3>
	  <p>Now, let's see the code in action. Imagine you're inside a controller:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// ...</span>
<span class="k">use</span> <span class="nx">Acme\StoreBundle\Entity\Category</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Acme\StoreBundle\Entity\Product</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Response</span><span class="p">;</span>
<span class="c1">// ...</span>

<span class="k">class</span> <span class="nc">DefaultController</span> <span class="k">extends</span> <span class="nx">Controller</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">createProductAction</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="nv">$category</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Category</span><span class="p">();</span>
        <span class="nv">$category</span><span class="o">-&gt;</span><span class="na">setName</span><span class="p">(</span><span class="s1">'Main Products'</span><span class="p">);</span>

        <span class="nv">$product</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Product</span><span class="p">();</span>
        <span class="nv">$product</span><span class="o">-&gt;</span><span class="na">setName</span><span class="p">(</span><span class="s1">'Foo'</span><span class="p">);</span>
        <span class="nv">$product</span><span class="o">-&gt;</span><span class="na">setPrice</span><span class="p">(</span><span class="mf">19.99</span><span class="p">);</span>
        <span class="c1">// relate this product to the category</span>
        <span class="nv">$product</span><span class="o">-&gt;</span><span class="na">setCategory</span><span class="p">(</span><span class="nv">$category</span><span class="p">);</span>

        <span class="nv">$em</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">getEntityManager</span><span class="p">();</span>
        <span class="nv">$em</span><span class="o">-&gt;</span><span class="na">persist</span><span class="p">(</span><span class="nv">$category</span><span class="p">);</span>
        <span class="nv">$em</span><span class="o">-&gt;</span><span class="na">persist</span><span class="p">(</span><span class="nv">$product</span><span class="p">);</span>
        <span class="nv">$em</span><span class="o">-&gt;</span><span class="na">flush</span><span class="p">();</span>

        <span class="k">return</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span>
            <span class="s1">'Created product id: '</span><span class="o">.</span><span class="nv">$product</span><span class="o">-&gt;</span><span class="na">getId</span><span class="p">()</span><span class="o">.</span><span class="s1">' and category id: '</span><span class="o">.</span><span class="nv">$category</span><span class="o">-&gt;</span><span class="na">getId</span><span class="p">()</span>
        <span class="p">);</span>
    <span class="p">}</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>Now, a single row is added to both the <tt class="docutils literal"><span class="pre">category</span></tt> and <tt class="docutils literal"><span class="pre">product</span></tt> tables.
	    The <tt class="docutils literal"><span class="pre">product.category_id</span></tt> column for the new product is set to whatever
	    the <tt class="docutils literal"><span class="pre">id</span></tt> is of the new category. Doctrine manages the persistence of this
	    relationship for you.</p>
	</div>
	<div class="section" id="fetching-related-objects">
	  <h3>Fetching Related Objects<a class="headerlink" href="#fetching-related-objects" title="Permalink to this headline">¶</a></h3>
	  <p>When you need to fetch associated objects, your workflow looks just like it
	    did before. First, fetch a <tt class="docutils literal"><span class="pre">$product</span></tt> object and then access its related
	    <tt class="docutils literal"><span class="pre">Category</span></tt>:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">showAction</span><span class="p">(</span><span class="nv">$id</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$product</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">)</span>
        <span class="o">-&gt;</span><span class="na">getEntityManager</span><span class="p">()</span>
        <span class="o">-&gt;</span><span class="na">getRepository</span><span class="p">(</span><span class="s1">'AcmeStoreBundle:Product'</span><span class="p">)</span>
        <span class="o">-&gt;</span><span class="na">find</span><span class="p">(</span><span class="nv">$id</span><span class="p">);</span>

    <span class="nv">$categoryName</span> <span class="o">=</span> <span class="nv">$product</span><span class="o">-&gt;</span><span class="na">getCategory</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">getName</span><span class="p">();</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>In this example, you first query for a <tt class="docutils literal"><span class="pre">Product</span></tt> object based on the product's
	    <tt class="docutils literal"><span class="pre">id</span></tt>. This issues a query for <em>just</em> the product data and hydrates the
	    <tt class="docutils literal"><span class="pre">$product</span></tt> object with that data. Later, when you call <tt class="docutils literal"><span class="pre">$product-&gt;getCategory()-&gt;getName()</span></tt>,
	    Doctrine silently makes a second query to find the <tt class="docutils literal"><span class="pre">Category</span></tt> that's related
	    to this <tt class="docutils literal"><span class="pre">Product</span></tt>. It prepares the <tt class="docutils literal"><span class="pre">$category</span></tt> object and returns it to
	    you.</p>
	  <img alt="../_images/doctrine_image_3.png" class="align-center" src="../_images/doctrine_image_3.png">
	  <p>What's important is the fact that you have easy access to the product's related
	    category, but the category data isn't actually retrieved until you ask for
	    the category (i.e. it's "lazily loaded").</p>
	  <p>You can also query in the other direction:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">showProductAction</span><span class="p">(</span><span class="nv">$id</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$category</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">)</span>
        <span class="o">-&gt;</span><span class="na">getEntityManager</span><span class="p">()</span>
        <span class="o">-&gt;</span><span class="na">getRepository</span><span class="p">(</span><span class="s1">'AcmeStoreBundle:Category'</span><span class="p">)</span>
        <span class="o">-&gt;</span><span class="na">find</span><span class="p">(</span><span class="nv">$id</span><span class="p">);</span>

    <span class="nv">$products</span> <span class="o">=</span> <span class="nv">$category</span><span class="o">-&gt;</span><span class="na">getProducts</span><span class="p">();</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>In this case, the same things occurs: you first query out for a single <tt class="docutils literal"><span class="pre">Category</span></tt>
	    object, and then Doctrine makes a second query to retrieve the related <tt class="docutils literal"><span class="pre">Product</span></tt>
	    objects, but only once/if you ask for them (i.e. when you call <tt class="docutils literal"><span class="pre">-&gt;getProducts()</span></tt>).
	    The <tt class="docutils literal"><span class="pre">$products</span></tt> variable is an array of all <tt class="docutils literal"><span class="pre">Product</span></tt> objects that relate
	    to the given <tt class="docutils literal"><span class="pre">Category</span></tt> object via their <tt class="docutils literal"><span class="pre">category_id</span></tt> value.</p>
	  <div class="admonition-wrapper">
	    <div class="sidebar"></div><div class="admonition admonition-sidebar"><p class="first sidebar-title">Relationships and Proxy Classes</p>
	      <p>This "lazy loading" is possible because, when necessary, Doctrine returns
		a "proxy" object in place of the true object. Look again at the above
		example:</p>
	      <div class="highlight-php"><div class="highlight"><pre><span class="nv">$product</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">)</span>
    <span class="o">-&gt;</span><span class="na">getEntityManager</span><span class="p">()</span>
    <span class="o">-&gt;</span><span class="na">getRepository</span><span class="p">(</span><span class="s1">'AcmeStoreBundle:Product'</span><span class="p">)</span>
    <span class="o">-&gt;</span><span class="na">find</span><span class="p">(</span><span class="nv">$id</span><span class="p">);</span>

<span class="nv">$category</span> <span class="o">=</span> <span class="nv">$product</span><span class="o">-&gt;</span><span class="na">getCategory</span><span class="p">();</span>

<span class="nx">prints</span> <span class="s2">"Proxies\AcmeStoreBundleEntityCategoryProxy"</span>
<span class="k">echo</span> <span class="nb">get_class</span><span class="p">(</span><span class="nv">$category</span><span class="p">);</span>
		</pre></div>
	      </div>
	      <p>This proxy object extends the true <tt class="docutils literal"><span class="pre">Category</span></tt> object, and looks and
		acts exactly like it. The difference is that, by using a proxy object,
		Doctrine can delay querying for the real <tt class="docutils literal"><span class="pre">Category</span></tt> data until you
		actually need that data (e.g. until you call <tt class="docutils literal"><span class="pre">$category-&gt;getName()</span></tt>).</p>
	      <p>The proxy classes are generated by Doctrine and stored in the cache directory.
		And though you'll probably never even notice that your <tt class="docutils literal"><span class="pre">$category</span></tt>
		object is actually a proxy object, it's important to keep in mind.</p>
	      <p class="last">In the next section, when you retrieve the product and category data
		all at once (via a <em>join</em>), Doctrine will return the <em>true</em> <tt class="docutils literal"><span class="pre">Category</span></tt>
		object, since nothing needs to be lazily loaded.</p>
	  </div></div>
	</div>
	<div class="section" id="joining-to-related-records">
	  <h3>Joining to Related Records<a class="headerlink" href="#joining-to-related-records" title="Permalink to this headline">¶</a></h3>
	  <p>In the above examples, two queries were made - one for the original object
	    (e.g. a <tt class="docutils literal"><span class="pre">Category</span></tt>) and one for the related object(s) (e.g. the <tt class="docutils literal"><span class="pre">Product</span></tt>
	    objects).</p>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">Remember that you can see all of the queries made during a request via
		the web debug toolbar.</p>
	  </div></div>
	  <p>Of course, if you know up front that you'll need to access both objects, you
	    can avoid the second query by issuing a join in the original query. Add the
	    following method to the <tt class="docutils literal"><span class="pre">ProductRepository</span></tt> class:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/StoreBundle/Repository/ProductRepository.php</span>

<span class="k">public</span> <span class="k">function</span> <span class="nf">findOneByIdJoinedToCategory</span><span class="p">(</span><span class="nv">$id</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$query</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">getEntityManager</span><span class="p">()</span>
        <span class="o">-&gt;</span><span class="na">createQuery</span><span class="p">(</span><span class="s1">'</span>
<span class="s1">            SELECT p, c FROM AcmeStoreBundle:Product p</span>
<span class="s1">            JOIN p.category c</span>
<span class="s1">            WHERE p.id = :id'</span>
        <span class="p">)</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'id'</span><span class="p">,</span> <span class="nv">$id</span><span class="p">);</span>

    <span class="k">try</span> <span class="p">{</span>
        <span class="k">return</span> <span class="nv">$query</span><span class="o">-&gt;</span><span class="na">getSingleResult</span><span class="p">();</span>
    <span class="p">}</span> <span class="k">catch</span> <span class="p">(</span><span class="nx">\Doctrine\ORM\NoResultException</span> <span class="nv">$e</span><span class="p">)</span> <span class="p">{</span>
        <span class="k">return</span> <span class="k">null</span><span class="p">;</span>
    <span class="p">}</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>Now, you can use this method in your controller to query for a <tt class="docutils literal"><span class="pre">Product</span></tt>
	    object and its related <tt class="docutils literal"><span class="pre">Category</span></tt> with just one query:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">showAction</span><span class="p">(</span><span class="nv">$id</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$product</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">)</span>
        <span class="o">-&gt;</span><span class="na">getEntityManager</span><span class="p">()</span>
        <span class="o">-&gt;</span><span class="na">getRepository</span><span class="p">(</span><span class="s1">'AcmeStoreBundle:Product'</span><span class="p">)</span>
        <span class="o">-&gt;</span><span class="na">findOneByIdJoinedToCategory</span><span class="p">(</span><span class="nv">$id</span><span class="p">);</span>

    <span class="nv">$category</span> <span class="o">=</span> <span class="nv">$product</span><span class="o">-&gt;</span><span class="na">getCategory</span><span class="p">();</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="more-information-on-associations">
	  <h3>More Information on Associations<a class="headerlink" href="#more-information-on-associations" title="Permalink to this headline">¶</a></h3>
	  <p>This section has been an introduction to one common type of entity relationship,
	    the one-to-many relationship. For more advanced details and examples of how
	    to use other types of relations (e.g. <tt class="docutils literal"><span class="pre">one-to-one</span></tt>, <tt class="docutils literal"><span class="pre">many-to-many</span></tt>), see
	    Doctrine's <a class="reference external" href="http://www.doctrine-project.org/docs/orm/2.0/en/reference/association-mapping.html">Association Mapping Documentation</a>.</p>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">If you're using annotations, you'll need to prepend all annotations with
		<tt class="docutils literal"><span class="pre">ORM\</span></tt> (e.g. <tt class="docutils literal"><span class="pre">ORM\OneToMany</span></tt>), which is not reflected in Doctrine's
		documentation. You'll also need to include the <tt class="docutils literal"><span class="pre">use</span> <span class="pre">Doctrine\ORM\Mapping</span> <span class="pre">as</span> <span class="pre">ORM;</span></tt>
		statement, which <em>imports</em> the <tt class="docutils literal"><span class="pre">ORM</span></tt> annotations prefix.</p>
	  </div></div>
	</div>
      </div>
      <div class="section" id="configuration">
	<h2>Configuration<a class="headerlink" href="#configuration" title="Permalink to this headline">¶</a></h2>
	<p>Doctrine is highly configurable, though you probably won't ever need to worry
	  about most of its options. To find out more about configuring Doctrine, see
	  the Doctrine section of the <a class="reference internal" href="../reference/configuration/doctrine.html"><em>reference manual</em></a>.</p>
      </div>
      <div class="section" id="lifecycle-callbacks">
	<h2>Lifecycle Callbacks<a class="headerlink" href="#lifecycle-callbacks" title="Permalink to this headline">¶</a></h2>
	<p>Sometimes, you need to perform an action right before or after an entity
	  is inserted, updated, or deleted. These types of actions are known as "lifecycle"
	  callbacks, as they're callback methods that you need to execute during different
	  stages of the lifecycle of an entity (e.g. the entity is inserted, updated,
	  deleted, etc).</p>
	<p>If you're using annotations for your metadata, start by enabling the lifecycle
	  callbacks. This is not necessary if you're using YAML or XML for your mapping:</p>
	<div class="highlight-php-annotations"><div class="highlight"><pre><span class="sd">/**</span>
<span class="sd"> * @ORM\Entity()</span>
<span class="sd"> * @ORM\HasLifecycleCallbacks()</span>
<span class="sd"> */</span>
<span class="k">class</span> <span class="nc">Product</span>
<span class="p">{</span>
    <span class="c1">// ...</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>Now, you can tell Doctrine to execute a method on any of the available lifecycle
	  events. For example, suppose you want to set a <tt class="docutils literal"><span class="pre">created</span></tt> date column to
	  the current date, only when the entity is first persisted (i.e. inserted):</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 184px; ">
	    <li class="selected"><em><a href="#">Annotations</a></em><div class="highlight-php-annotations" style="width: 690px; display: block; "><div class="highlight"><pre><span class="sd">/**</span>
<span class="sd"> * @ORM\prePersist</span>
<span class="sd"> */</span>
<span class="k">public</span> <span class="k">function</span> <span class="nf">setCreatedValue</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">created</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">\DateTime</span><span class="p">();</span>
<span class="p">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">YAML</a></em><div class="highlight-yaml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1"># src/Acme/StoreBundle/Resources/config/doctrine/Product.orm.yml</span>
<span class="l-Scalar-Plain">Acme\StoreBundle\Entity\Product</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">type</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">entity</span>
    <span class="c1"># ...</span>
    <span class="l-Scalar-Plain">lifecycleCallbacks</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">prePersist</span><span class="p-Indicator">:</span> <span class="p-Indicator">[</span> <span class="nv">setCreatedValue</span> <span class="p-Indicator">]</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><pre>&lt;!-- src/Acme/StoreBundle/Resources/config/doctrine/Product.orm.xml --&gt;
&lt;!-- ... --&gt;
&lt;doctrine-mapping&gt;

    &lt;entity name="Acme\StoreBundle\Entity\Product" ... &gt;
            &lt;!-- ... --&gt;
            &lt;lifecycle-callbacks&gt;
                &lt;lifecycle-callback type="prePersist" method="setCreatedValue" /&gt;
            &lt;/lifecycle-callbacks&gt;
    &lt;/entity&gt;
		  &lt;/doctrine-mapping&gt;</pre>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">The above example assumes that you've created and mapped a <tt class="docutils literal"><span class="pre">created</span></tt>
	      property (not shown here).</p>
	</div></div>
	<p>Now, right before the entity is first persisted, Doctrine will automatically
	  call this method and the <tt class="docutils literal"><span class="pre">created</span></tt> field will be set to the current date.</p>
	<p>This can be repeated for any of the other lifecycle events, which include:</p>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">preRemove</span></tt></li>
	  <li><tt class="docutils literal"><span class="pre">postRemove</span></tt></li>
	  <li><tt class="docutils literal"><span class="pre">prePersist</span></tt></li>
	  <li><tt class="docutils literal"><span class="pre">postPersist</span></tt></li>
	  <li><tt class="docutils literal"><span class="pre">preUpdate</span></tt></li>
	  <li><tt class="docutils literal"><span class="pre">postUpdate</span></tt></li>
	  <li><tt class="docutils literal"><span class="pre">postLoad</span></tt></li>
	  <li><tt class="docutils literal"><span class="pre">loadClassMetadata</span></tt></li>
	</ul>
	<p>For more information on what these lifecycle events mean and lifecycle callbacks
	  in general, see Doctrine's <a class="reference external" href="http://www.doctrine-project.org/docs/orm/2.0/en/reference/events.html#lifecycle-events">Lifecycle Events documentation</a></p>
	<div class="admonition-wrapper">
	  <div class="sidebar"></div><div class="admonition admonition-sidebar"><p class="first sidebar-title">Lifecycle Callbacks and Event Listeners</p>
	    <p>Notice that the <tt class="docutils literal"><span class="pre">setCreatedValue()</span></tt> method receives no arguments. This
	      is always the case for lifecylce callbacks and is intentional: lifecycle
	      callbacks should be simple methods that are concerned with internally
	      transforming data in the entity (e.g. setting a created/updated field,
	      generating a slug value).</p>
	    <p class="last">If you need to do some heavier lifting - like perform logging or send
	      an email - you should register an external class as an event listener
	      or subscriber and give it access to whatever resources you need. For
	      more information, see <a class="reference internal" href="../cookbook/doctrine/event_listeners_subscribers.html"><em>Registering Event Listeners and Subscribers</em></a>.</p>
	</div></div>
      </div>
      <div class="section" id="doctrine-extensions-timestampable-sluggable-etc">
	<h2>Doctrine Extensions: Timestampable, Sluggable, etc.<a class="headerlink" href="#doctrine-extensions-timestampable-sluggable-etc" title="Permalink to this headline">¶</a></h2>
	<p>Doctrine is quite flexible, and a number of third-party extensions are available
	  that allow you to easily perform repeated and common tasks on your entities.
	  These include thing such as <em>Sluggable</em>, <em>Timestampable</em>, <em>Loggable</em>, <em>Translatable</em>,
	  and <em>Tree</em>.</p>
	<p>For more information on how to find and use these extensions, see the cookbook
	  article about <a class="reference internal" href="../cookbook/doctrine/common_extensions.html"><em>using common Doctrine extensions</em></a>.</p>
      </div>
      <div class="section" id="doctrine-field-types-reference">
	<span id="book-doctrine-field-types"></span><h2>Doctrine Field Types Reference<a class="headerlink" href="#doctrine-field-types-reference" title="Permalink to this headline">¶</a></h2>
	<p>Doctrine comes with a large number of field types available. Each of these
	  maps a PHP data type to a specific column type in whatever database you're
	  using. The following types are supported in Doctrine:</p>
	<ul class="simple">
	  <li><strong>Strings</strong><ul>
	      <li><tt class="docutils literal"><span class="pre">string</span></tt> (used for shorter strings)</li>
	      <li><tt class="docutils literal"><span class="pre">text</span></tt> (used for larger strings)</li>
	    </ul>
	  </li>
	  <li><strong>Numbers</strong><ul>
	      <li><tt class="docutils literal"><span class="pre">integer</span></tt></li>
	      <li><tt class="docutils literal"><span class="pre">smallint</span></tt></li>
	      <li><tt class="docutils literal"><span class="pre">bigint</span></tt></li>
	      <li><tt class="docutils literal"><span class="pre">decimal</span></tt></li>
	      <li><tt class="docutils literal"><span class="pre">float</span></tt></li>
	    </ul>
	  </li>
	  <li><strong>Dates and Times</strong> (use a <a class="reference external" href="http://php.net/manual/en/class.datetime.php">DateTime</a> object for these fields in PHP)<ul>
	      <li><tt class="docutils literal"><span class="pre">date</span></tt></li>
	      <li><tt class="docutils literal"><span class="pre">time</span></tt></li>
	      <li><tt class="docutils literal"><span class="pre">datetime</span></tt></li>
	    </ul>
	  </li>
	  <li><strong>Other Types</strong><ul>
	      <li><tt class="docutils literal"><span class="pre">boolean</span></tt></li>
	      <li><tt class="docutils literal"><span class="pre">object</span></tt> (serialized and stored in a <tt class="docutils literal"><span class="pre">CLOB</span></tt> field)</li>
	      <li><tt class="docutils literal"><span class="pre">array</span></tt> (serialized and stored in a <tt class="docutils literal"><span class="pre">CLOB</span></tt> field)</li>
	    </ul>
	  </li>
	</ul>
	<p>For more information, see Doctrine's <a class="reference external" href="http://www.doctrine-project.org/docs/orm/2.0/en/reference/basic-mapping.html#doctrine-mapping-types">Mapping Types documentation</a>.</p>
	<div class="section" id="field-options">
	  <h3>Field Options<a class="headerlink" href="#field-options" title="Permalink to this headline">¶</a></h3>
	  <p>Each field can have a set of options applied to it. The available options
	    include <tt class="docutils literal"><span class="pre">type</span></tt> (defaults to <tt class="docutils literal"><span class="pre">string</span></tt>), <tt class="docutils literal"><span class="pre">name</span></tt>, <tt class="docutils literal"><span class="pre">length</span></tt>, <tt class="docutils literal"><span class="pre">unique</span></tt>
	    and <tt class="docutils literal"><span class="pre">nullable</span></tt>. Take a few annotations examples:</p>
	  <div class="highlight-php-annotations"><div class="highlight"><pre><span class="sd">/**</span>
<span class="sd"> * A string field with length 255 that cannot be null</span>
<span class="sd"> * (reflecting the default values for the "type", "length" and *nullable* options)</span>
<span class="sd"> *</span>
<span class="sd"> * @ORM\Column()</span>
<span class="sd"> */</span>
<span class="k">protected</span> <span class="nv">$name</span><span class="p">;</span>

<span class="sd">/**</span>
<span class="sd"> * A string field of length 150 that persists to an "email_address" column</span>
<span class="sd"> * and has a unique index.</span>
<span class="sd"> *</span>
<span class="sd"> * @ORM\Column(name="email_address", unique="true", length="150")</span>
<span class="sd"> */</span>
<span class="k">protected</span> <span class="nv">$email</span><span class="p">;</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">There are a few more options not listed here. For more details, see
		Doctrine's <a class="reference external" href="http://www.doctrine-project.org/docs/orm/2.0/en/reference/basic-mapping.html#property-mapping">Property Mapping documentation</a></p>
	  </div></div>
	</div>
      </div>
      <div class="section" id="console-commands">
	<span id="index-1"></span><h2>Console Commands<a class="headerlink" href="#console-commands" title="Permalink to this headline">¶</a></h2>
	<p>The Doctrine2 ORM integration offers several console commands under the
	  <tt class="docutils literal"><span class="pre">doctrine</span></tt> namespace. To view the command list you can run the console
	  without any arguments:</p>
	<div class="highlight-bash"><div class="highlight"><pre>php app/console
	  </pre></div>
	</div>
	<p>A list of available command will print out, many of which start with the
	  <tt class="docutils literal"><span class="pre">doctrine:</span></tt> prefix. You can find out more information about any of these
	  commands (or any Symfony command) by running the <tt class="docutils literal"><span class="pre">help</span></tt> command. For example,
	  to get details about the <tt class="docutils literal"><span class="pre">doctrine:database:create</span></tt> task, run:</p>
	<div class="highlight-bash"><div class="highlight"><pre>php app/console <span class="nb">help </span>doctrine:database:create
	  </pre></div>
	</div>
	<p>Some notable or interesting tasks include:</p>
	<ul>
	  <li><p class="first"><tt class="docutils literal"><span class="pre">doctrine:ensure-production-settings</span></tt> - checks to see if the current
	      environment is configured efficiently for production. This should always
	      be run in the <tt class="docutils literal"><span class="pre">prod</span></tt> environment:</p>
	    <div class="highlight-bash"><div class="highlight"><pre>php app/console doctrine:ensure-production-settings --env<span class="o">=</span>prod
	      </pre></div>
	    </div>
	  </li>
	  <li><p class="first"><tt class="docutils literal"><span class="pre">doctrine:mapping:import</span></tt> - allows Doctrine to introspect an existing
	      database and create mapping information. For more information, see
	      <a class="reference internal" href="../cookbook/doctrine/reverse_engineering.html"><em>How to generate Entities from an Existing Database</em></a>.</p>
	  </li>
	  <li><p class="first"><tt class="docutils literal"><span class="pre">doctrine:mapping:info</span></tt> - tells you all of the entities that Doctrine
	      is aware of and whether or not there are any basic errors with the mapping.</p>
	  </li>
	  <li><p class="first"><tt class="docutils literal"><span class="pre">doctrine:query:dql</span></tt> and <tt class="docutils literal"><span class="pre">doctrine:query:sql</span></tt> - allow you to execute
	      DQL or SQL queries directly from the command line.</p>
	  </li>
	</ul>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">To be able to load data fixtures to your database, you will need to have the
	      <tt class="docutils literal"><span class="pre">DoctrineFixturesBundle</span></tt> bundle installed. To learn how to do it,
	      read the "<a class="reference internal" href="../cookbook/doctrine/doctrine_fixtures.html"><em>How to create Fixtures in Symfony2</em></a>" entry of the Cookbook.</p>
	</div></div>
      </div>
      <div class="section" id="summary">
	<h2>Summary<a class="headerlink" href="#summary" title="Permalink to this headline">¶</a></h2>
	<p>With Doctrine, you can focus on your objects and how they're useful in your
	  application and worry about database persistence second. This is because
	  Doctrine allows you to use any PHP object to hold your data and relies on
	  mapping metadata information to map an object's data to a particular database
	  table.</p>
	<p>And even though Doctrine revolves around a simple concept, it's incredibly
	  powerful, allowing you to create complex queries and subscribe to events
	  that allow you to take different actions as objects go through their persistence
	  lifecycle.</p>
	<p>For more information about Doctrine, see the <em>Doctrine</em> section of the
	  <a class="reference internal" href="../cookbook/index.html"><em>cookbook</em></a>, which includes the following articles:</p>
	<ul class="simple">
	  <li><a class="reference internal" href="../cookbook/doctrine/doctrine_fixtures.html"><em>How to create Fixtures in Symfony2</em></a></li>
	  <li><a class="reference internal" href="../cookbook/doctrine/migrations.html"><em>How to use Doctrine Migrations</em></a></li>
	  <li><a class="reference internal" href="../cookbook/doctrine/mongodb.html"><em>How to use MongoDB</em></a></li>
	  <li><a class="reference internal" href="../cookbook/doctrine/common_extensions.html"><em>Doctrine Extensions: Timestampable: Sluggable, Translatable, etc.</em></a></li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Creating and using Templates" href="templating.html">
      «&nbsp;Creating and using Templates
    </a><span class="separator">|</span>
    <a accesskey="N" title="Testing" href="testing.html">
      Testing&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
