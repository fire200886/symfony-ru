<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to use Doctrine Migrations</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-use-doctrine-migrations">
      <span id="index-0"></span><h1>How to use Doctrine Migrations<a class="headerlink" href="#how-to-use-doctrine-migrations" title="Permalink to this headline">¶</a></h1>
      <p>The database migrations feature is an extension of the database abstraction
	layer and offers you the ability to programmatically deploy new versions of
	your database schema in a safe, easy and standardized way.</p>
      <div class="admonition-wrapper">
	<div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	  <p class="last">You can read more about the Doctrine Database Migrations on the project's
	    <a class="reference external" href="http://www.doctrine-project.org/projects/migrations/2.0/docs/reference/introduction/en">documentation</a>.</p>
      </div></div>
      <div class="section" id="installation">
	<h2>Installation<a class="headerlink" href="#installation" title="Permalink to this headline">¶</a></h2>
	<p>Doctrine migrations for Symfony are maintained in the <a class="reference external" href="https://github.com/symfony/DoctrineMigrationsBundle">DoctrineMigrationsBundle</a>.
	  Make sure you have both the <tt class="docutils literal"><span class="pre">doctrine-migrations</span></tt> and <tt class="docutils literal"><span class="pre">DoctrineMigrationsBundle</span></tt>
	  libraries configured in your project. Follow these steps to install the
	  libraries in the Symfony Standard distribution.</p>
	<p>Add the following to <tt class="docutils literal"><span class="pre">bin/deps</span></tt>. This will register the Migrations Bundle
	  and the doctrine-migrations library as dependencies in your application:</p>
	<div class="highlight-text"><div class="highlight"><pre>/                       doctrine-migrations       https://github.com/doctrine/migrations.git
/bundles/Symfony/Bundle DoctrineMigrationsBundle  https://github.com/symfony/DoctrineMigrationsBundle.git
	  </pre></div>
	</div>
	<p>Update the vendor libraries:</p>
	<div class="highlight-bash"><div class="highlight"><pre><span class="nv">$ </span>php bin/vendors.php
	  </pre></div>
	</div>
	<p>Next, ensure the new <tt class="docutils literal"><span class="pre">Doctrine\DBAL\Migrations</span></tt> namespace will be autoloaded
	  via <tt class="docutils literal"><span class="pre">autoload.php</span></tt>. The new <tt class="docutils literal"><span class="pre">Migrations</span></tt> namespace <em>must</em> be placed above
	  the <tt class="docutils literal"><span class="pre">Doctrine\\DBAL</span></tt> entry so that the autoloader looks inside the migrations
	  directory for those classes:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// app/autoload.php</span>
<span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">registerNamespaces</span><span class="p">(</span><span class="k">array</span><span class="p">(</span>
    <span class="c1">//...</span>
    <span class="s1">'Doctrine\\DBAL\\Migrations'</span> <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../vendor/doctrine-migrations/lib'</span><span class="p">,</span>
    <span class="s1">'Doctrine\\DBAL'</span>             <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../vendor/doctrine-dbal/lib'</span><span class="p">,</span>
<span class="p">));</span>
	  </pre></div>
	</div>
	<p>Finally, be sure to enable the bundle in <tt class="docutils literal"><span class="pre">AppKernel.php</span></tt> by including the
	  following:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// app/AppKernel.php</span>
<span class="k">public</span> <span class="k">function</span> <span class="nf">registerBundles</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$bundles</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span>
        <span class="c1">//...</span>
        <span class="k">new</span> <span class="nx">Symfony\Bundle\DoctrineMigrationsBundle\DoctrineMigrationsBundle</span><span class="p">(),</span>
    <span class="p">);</span>
<span class="p">}</span>
	  </pre></div>
	</div>
      </div>
      <div class="section" id="usage">
	<h2>Usage<a class="headerlink" href="#usage" title="Permalink to this headline">¶</a></h2>
	<p>All of the migrations functionality is contained in a few console commands:</p>
	<div class="highlight-bash"><div class="highlight"><pre>doctrine:migrations
  :diff     Generate a migration by comparing your current database to your mapping information.
  :execute  Execute a single migration version up or down manually.
  :generate Generate a blank migration class.
  :migrate  Execute a migration to a specified version or the latest available version.
  :status   View the status of a <span class="nb">set </span>of migrations.
  :version  Manually add and delete migration versions from the version table.
	  </pre></div>
	</div>
	<p>Start by getting the status of migrations in your application by running
	  the <tt class="docutils literal"><span class="pre">status</span></tt> command:</p>
	<div class="highlight-bash"><div class="highlight"><pre><span class="nv">$ </span>php app/console doctrine:migrations:status

 <span class="o">==</span> Configuration

    &gt;&gt; Name:                                               Application Migrations
    &gt;&gt; Configuration Source:                               manually configured
    &gt;&gt; Version Table Name:                                 migration_versions
    &gt;&gt; Migrations Namespace:                               Application<span class="se">\M</span>igrations
    &gt;&gt; Migrations Directory:                               /path/to/project/app/DoctrineMigrations
    &gt;&gt; Current Version:                                    0
    &gt;&gt; Latest Version:                                     0
    &gt;&gt; Executed Migrations:                                0
    &gt;&gt; Available Migrations:                               0
    &gt;&gt; New Migrations:                                     0
	  </pre></div>
	</div>
	<p>Now, you can start working with migrations by generating a new blank migration
	  class. Later, you'll learn how Doctrine can generate migrations automatically
	  for you.</p>
	<div class="highlight-bash"><div class="highlight"><pre><span class="nv">$ </span>php app/console doctrine:migrations:generate
Generated new migration class to <span class="s2">"/path/to/project/app/DoctrineMigrations/Version20100621140655.php"</span>
	  </pre></div>
	</div>
	<p>Have a look at the newly generated migration class and you will see something
	  like the following:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">namespace</span> <span class="nx">Application\Migrations</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Doctrine\DBAL\Migrations\AbstractMigration</span><span class="p">,</span>
    <span class="nx">Doctrine\DBAL\Schema\Schema</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Version20100621140655</span> <span class="k">extends</span> <span class="nx">AbstractMigration</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">up</span><span class="p">(</span><span class="nx">Schema</span> <span class="nv">$schema</span><span class="p">)</span>
    <span class="p">{</span>

    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">down</span><span class="p">(</span><span class="nx">Schema</span> <span class="nv">$schema</span><span class="p">)</span>
    <span class="p">{</span>

    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>If you run the <tt class="docutils literal"><span class="pre">status</span></tt> command it will now show that you have one new
	  migration to execute:</p>
	<div class="highlight-bash"><div class="highlight"><pre><span class="nv">$ </span>php app/console doctrine:migrations:status

 <span class="o">==</span> Configuration

   &gt;&gt; Name:                                               Application Migrations
   &gt;&gt; Configuration Source:                               manually configured
   &gt;&gt; Version Table Name:                                 migration_versions
   &gt;&gt; Migrations Namespace:                               Application<span class="se">\M</span>igrations
   &gt;&gt; Migrations Directory:                               /path/to/project/app/DoctrineMigrations
   &gt;&gt; Current Version:                                    0
   &gt;&gt; Latest Version:                                     2010-06-21 14:06:55 <span class="o">(</span>20100621140655<span class="o">)</span>
   &gt;&gt; Executed Migrations:                                0
   &gt;&gt; Available Migrations:                               1
   &gt;&gt; New Migrations:                                     <span class="nv">1</span>

<span class="o">==</span> Migration Versions

   &gt;&gt; 2010-06-21 14:06:55 <span class="o">(</span>20100621140655<span class="o">)</span>                not migrated
	  </pre></div>
	</div>
	<p>Now you can add some migration code to the <tt class="docutils literal"><span class="pre">up()</span></tt> and <tt class="docutils literal"><span class="pre">down()</span></tt> methods and
	  finally migrate when you're ready:</p>
	<div class="highlight-bash"><div class="highlight"><pre><span class="nv">$ </span>php app/console doctrine:migrations:migrate
	  </pre></div>
	</div>
	<p>For more information on how to write the migrations themselves (i.e. how to
	  fill in the <tt class="docutils literal"><span class="pre">up()</span></tt> and <tt class="docutils literal"><span class="pre">down()</span></tt> methods), see the official Doctrine Migrations
	  <a class="reference external" href="http://www.doctrine-project.org/projects/migrations/2.0/docs/reference/introduction/en">documentation</a>.</p>
	<div class="section" id="running-migrations-during-deployment">
	  <h3>Running Migrations during Deployment<a class="headerlink" href="#running-migrations-during-deployment" title="Permalink to this headline">¶</a></h3>
	  <p>Of course, the end goal of writing migrations is to be able to use them to
	    reliably update your database structure when you deploy your application.
	    By running the migrations locally (or on a beta server), you can ensure that
	    the migrations work as you expect.</p>
	  <p>When you do finally deploy your application, you just need to remember to run
	    the <tt class="docutils literal"><span class="pre">doctrine:migrations:migrate</span></tt> command. Internally, Doctrine creates
	    a <tt class="docutils literal"><span class="pre">migration_versions</span></tt> table inside your database and tracks which migrations
	    have been executed there. So, no matter how many migrations you've created
	    and executed locally, when you run the command during deployment, Doctrine
	    will know exactly which migrations it hasn't run yet by looking at the <tt class="docutils literal"><span class="pre">migration_versions</span></tt>
	    table of your production database. Regardless of what server you're on, you
	    can always safely run this command to execute only the migrations that haven't
	    been run yet on <em>that</em> particular database.</p>
	</div>
      </div>
      <div class="section" id="generating-migrations-automatically">
	<h2>Generating Migrations Automatically<a class="headerlink" href="#generating-migrations-automatically" title="Permalink to this headline">¶</a></h2>
	<p>In reality, you should rarely need to write migrations manually, as the migrations
	  library can generate migration classes automatically by comparing your Doctrine
	  mapping information (i.e. what your database <em>should</em> look like) with your
	  actual current database structure.</p>
	<p>For example, suppose you create a new <tt class="docutils literal"><span class="pre">User</span></tt> entity and add mapping information
	  for Doctrine's ORM:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 472px; ">
	    <li class="selected"><em><a href="#">Annotations</a></em><div class="highlight-php-annotations" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Entity/User.php</span>
<span class="k">namespace</span> <span class="nx">Acme\HelloBundle\Entity</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Doctrine\ORM\Mapping</span> <span class="k">as</span> <span class="nx">ORM</span><span class="p">;</span>

<span class="sd">/**</span>
<span class="sd"> * @ORM\Entity</span>
<span class="sd"> * @ORM\Table(name="hello_user")</span>
<span class="sd"> */</span>
<span class="k">class</span> <span class="nc">User</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @ORM\Id</span>
<span class="sd">     * @ORM\Column(type="integer")</span>
<span class="sd">     * @ORM\GeneratedValue(strategy="AUTO")</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$id</span><span class="p">;</span>

    <span class="sd">/**</span>
<span class="sd">     * @ORM\Column(type="string", length="255")</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$name</span><span class="p">;</span>
<span class="p">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">YAML</a></em><div class="highlight-yaml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1"># src/Acme/HelloBundle/Resources/config/doctrine/User.orm.yml</span>
<span class="l-Scalar-Plain">Acme\HelloBundle\Entity\User</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">type</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">entity</span>
    <span class="l-Scalar-Plain">table</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">hello_user</span>
    <span class="l-Scalar-Plain">id</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">id</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">type</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">integer</span>
            <span class="l-Scalar-Plain">generator</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">strategy</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">AUTO</span>
    <span class="l-Scalar-Plain">fields</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">name</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">type</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">string</span>
            <span class="l-Scalar-Plain">length</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">255</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/config/doctrine/User.orm.xml --&gt;</span>
<span class="nt">&lt;doctrine-mapping</span> <span class="na">xmlns=</span><span class="s">"http://doctrine-project.org/schemas/orm/doctrine-mapping"</span>
      <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
      <span class="na">xsi:schemaLocation=</span><span class="s">"http://doctrine-project.org/schemas/orm/doctrine-mapping</span>
<span class="s">                    http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;entity</span> <span class="na">name=</span><span class="s">"Acme\HelloBundle\Entity\User"</span> <span class="na">table=</span><span class="s">"hello_user"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;id</span> <span class="na">name=</span><span class="s">"id"</span> <span class="na">type=</span><span class="s">"integer"</span> <span class="na">column=</span><span class="s">"id"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;generator</span> <span class="na">strategy=</span><span class="s">"AUTO"</span><span class="nt">/&gt;</span>
        <span class="nt">&lt;/id&gt;</span>
        <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">"name"</span> <span class="na">column=</span><span class="s">"name"</span> <span class="na">type=</span><span class="s">"string"</span> <span class="na">length=</span><span class="s">"255"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/entity&gt;</span>

<span class="nt">&lt;/doctrine-mapping&gt;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>With this information, Doctrine is now ready to help you persist your new
	  <tt class="docutils literal"><span class="pre">User</span></tt> object to and from the <tt class="docutils literal"><span class="pre">hello_user</span></tt> table. Of course, this table
	  doesn't exist yet! Generate a new migration for this table automatically by
	  running the following command:</p>
	<div class="highlight-bash"><div class="highlight"><pre><span class="nv">$ </span>php app/console doctrine:migrations:diff
	  </pre></div>
	</div>
	<p>You should see a message that a new migration class was generated based on
	  the schema differences. If you open this file, you'll find that it has the
	  SQL code needed to create the <tt class="docutils literal"><span class="pre">hello_user</span></tt> table. Next, run the migration
	  to add the table to your database:</p>
	<div class="highlight-bash"><div class="highlight"><pre><span class="nv">$ </span>php app/console doctrine:migrations:migrate
	  </pre></div>
	</div>
	<p>The moral of the story is this: after each change you make to your Doctrine
	  mapping information, run the <tt class="docutils literal"><span class="pre">doctrine:migrations:diff</span></tt> command to automatically
	  generate your migration classes.</p>
	<p>If you do this from the very beginning of your project (i.e. so that even
	  the first tables were loaded via a migration class), you'll always be able
	  to create a fresh database and run your migrations in order to get your database
	  schema fully up to date. In fact, this is an easy and dependable workflow
	  for your project.</p>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to use MongoDB" href="mongodb.html">
      «&nbsp;How to use MongoDB
    </a><span class="separator">|</span>
    <a accesskey="N" title="Doctrine Extensions: Timestampable: Sluggable, Translatable, etc." href="common_extensions.html">
      Doctrine Extensions: Timestampable: Sluggable, Translatable, etc.&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
