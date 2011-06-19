<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to create Fixtures in Symfony2</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-create-fixtures-in-symfony2">
      <span id="index-0"></span><h1>How to create Fixtures in Symfony2<a class="headerlink" href="#how-to-create-fixtures-in-symfony2" title="Permalink to this headline">¶</a></h1>
      <p>Fixtures are used to load a controlled set of data into a database. This data
	can be used for testing or could be the initial data required for the
	application to run smoothly. Symfony2 has no built in way to manage fixtures
	but Doctrine2 has a library to help you write fixtures for the Doctrine
	<tt class="xref doc docutils literal"><span class="pre">ORM</span></tt> or <a class="reference internal" href="mongodb.html"><em>ODM</em></a>.</p>
      <div class="section" id="setup-and-configuration">
	<h2>Setup and Configuration<a class="headerlink" href="#setup-and-configuration" title="Permalink to this headline">¶</a></h2>
	<p>If you don't have the <a class="reference external" href="https://github.com/doctrine/data-fixtures">Doctrine Data Fixtures</a> library configured with Symfony2
	  yet, follow these steps to do so.</p>
	<p>If you're using the Standard Distribution, add the following to your <tt class="docutils literal"><span class="pre">bin/deps</span></tt>
	  file:</p>
	<div class="highlight-text"><div class="highlight"><pre>/                       doctrine-fixtures     http://github.com/doctrine/data-fixtures.git
/bundles/Symfony/Bundle DoctrineFixturesBundle http://github.com/symfony/DoctrineFixturesBundle.git
	  </pre></div>
	</div>
	<p>Update the vendor libraries:</p>
	<div class="highlight-bash"><div class="highlight"><pre><span class="nv">$ </span>php bin/vendors.php
	  </pre></div>
	</div>
	<p>If everything worked, the <tt class="docutils literal"><span class="pre">doctrine-fixtures</span></tt> library can now be found
	  at <tt class="docutils literal"><span class="pre">vendor/doctrine-fixtures</span></tt>.</p>
	<p>Register the <tt class="docutils literal"><span class="pre">Doctrine\Common\DataFixtures</span></tt> namespace in <tt class="docutils literal"><span class="pre">app/autoload.php</span></tt>.</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// ...</span>
<span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">registerNamespaces</span><span class="p">(</span><span class="k">array</span><span class="p">(</span>
    <span class="c1">// ...</span>
    <span class="s1">'Doctrine\\Common\\DataFixtures'</span> <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../vendor/doctrine-fixtures/lib'</span><span class="p">,</span>
    <span class="s1">'Doctrine\\Common'</span> <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../vendor/doctrine-common/lib'</span><span class="p">,</span>
    <span class="c1">// ...</span>
<span class="p">));</span>
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="caution"></div><div class="admonition admonition-caution"><p class="first admonition-title">Caution</p>
	    <p class="last">Be sure to register the new namespace <em>before</em> <tt class="docutils literal"><span class="pre">Doctrine\Common</span></tt>. Otherwise,
	      Symfony will look for data fixture classes inside the <tt class="docutils literal"><span class="pre">Doctrine\Common</span></tt>
	      directory. Symfony's autoloader always looks for a class inside the directory
	      of the first matching namespace, so more specific namespaces should always
	      come first.</p>
	</div></div>
	<p>Finally, register the Bundle <tt class="docutils literal"><span class="pre">DoctrineFixturesBundle</span></tt> in <tt class="docutils literal"><span class="pre">app/AppKernel.php</span></tt>.</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// ...</span>
<span class="k">public</span> <span class="k">function</span> <span class="nf">registerBundles</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$bundles</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span>
        <span class="c1">// ...</span>
        <span class="k">new</span> <span class="nx">Symfony\Bundle\DoctrineFixturesBundle\DoctrineFixturesBundle</span><span class="p">(),</span>
        <span class="c1">// ...</span>
    <span class="p">);</span>
    <span class="c1">// ...</span>
<span class="p">}</span>
	  </pre></div>
	</div>
      </div>
      <div class="section" id="writing-simple-fixtures">
	<h2>Writing Simple Fixtures<a class="headerlink" href="#writing-simple-fixtures" title="Permalink to this headline">¶</a></h2>
	<p>Doctrine2 fixtures are PHP classes where you can create objects and persist
	  them to the database. Like all classes in Symfony2, fixtures should live inside
	  one of your application bundles.</p>
	<p>For a bundle located at <tt class="docutils literal"><span class="pre">src/Acme/HelloBundle</span></tt>, the fixture classes
	  should live inside <tt class="docutils literal"><span class="pre">src/Acme/HelloBundle/DataFixtures/ORM</span></tt> or
	  <tt class="docutils literal"><span class="pre">src/Acme/HelloBundle/DataFixtures/ODM</span></tt> respectively for the ORM and ODM,
	  This tutorial assumes that you are using the ORM - but fixtures can be added
	  just as easily if you're using the ODM.</p>
	<p>Imagine that you have a <tt class="docutils literal"><span class="pre">User</span></tt> class, and you'd like to load one <tt class="docutils literal"><span class="pre">User</span></tt>
	  entry:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/DataFixtures/ORM/LoadUserData.php</span>
<span class="k">namespace</span> <span class="nx">Acme\HelloBundle\DataFixtures\ORM</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Doctrine\Common\DataFixtures\FixtureInterface</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Acme\HelloBundle\Entity\User</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">LoadUserData</span> <span class="k">implements</span> <span class="nx">FixtureInterface</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">load</span><span class="p">(</span><span class="nv">$manager</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$userAdmin</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">User</span><span class="p">();</span>
        <span class="nv">$userAdmin</span><span class="o">-&gt;</span><span class="na">setUsername</span><span class="p">(</span><span class="s1">'admin'</span><span class="p">);</span>
        <span class="nv">$userAdmin</span><span class="o">-&gt;</span><span class="na">setPassword</span><span class="p">(</span><span class="s1">'test'</span><span class="p">);</span>

        <span class="nv">$manager</span><span class="o">-&gt;</span><span class="na">persist</span><span class="p">(</span><span class="nv">$userAdmin</span><span class="p">);</span>
        <span class="nv">$manager</span><span class="o">-&gt;</span><span class="na">flush</span><span class="p">();</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>In Doctrine2, fixtures are just objects where you load data by interacting
	  with your entities as you normally do. This allows you to create the exact
	  fixtures you need for your application.</p>
	<p>The most serious limitation is that you cannot share objects between fixtures.
	  Later, you'll see how to overcome this limitation.</p>
      </div>
      <div class="section" id="executing-fixtures">
	<h2>Executing Fixtures<a class="headerlink" href="#executing-fixtures" title="Permalink to this headline">¶</a></h2>
	<p>Once your fixtures have been written, you can load them via the command
	  line by using the <tt class="docutils literal"><span class="pre">doctrine:fixtures:load</span></tt> command:</p>
	<div class="highlight-bash"><div class="highlight"><pre><span class="nv">$ </span>php app/console doctrine:fixtures:load
	  </pre></div>
	</div>
	<p>If you're using the ODM, use the <tt class="docutils literal"><span class="pre">doctrine:mongodb:fixtures:load</span></tt> command instead:</p>
	<div class="highlight-bash"><div class="highlight"><pre><span class="nv">$ </span>php app/console doctrine:mongodb:fixtures:load
	  </pre></div>
	</div>
	<p>The task will look inside the <tt class="docutils literal"><span class="pre">DataFixtures/ORM</span></tt> (or <tt class="docutils literal"><span class="pre">DataFixtures/ODM</span></tt>
	  for the ODM) directory of each bundle and execute each class that implements
	  the <tt class="docutils literal"><span class="pre">FixtureInterface</span></tt>.</p>
	<p>Both commands come with a few options:</p>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">--fixtures=/path/to/fixture</span></tt> - Use this option to manually specify the
	    directory or file where the fixtures classes should be loaded;</li>
	  <li><tt class="docutils literal"><span class="pre">--append</span></tt> - Use this flag to append data instead of deleting data before
	    loading it (deleting first is the default behavior);</li>
	  <li><tt class="docutils literal"><span class="pre">--em=manager_name</span></tt> - Manually specify the entity manager to use for
	    loading the data.</li>
	</ul>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">If using the <tt class="docutils literal"><span class="pre">doctrine:mongodb:fixtures:load</span></tt> task, replace the <tt class="docutils literal"><span class="pre">--em=</span></tt>
	      option with <tt class="docutils literal"><span class="pre">--dm=</span></tt> to manually specify the document manager.</p>
	</div></div>
	<p>A full example use might look like this:</p>
	<div class="highlight-bash"><div class="highlight"><pre><span class="nv">$ </span>php app/console doctrine:fixtures:load --fixtures<span class="o">=</span>/path/to/fixture1 --fixtures<span class="o">=</span>/path/to/fixture2 --append --em<span class="o">=</span>foo_manager
	  </pre></div>
	</div>
      </div>
      <div class="section" id="sharing-objects-between-fixtures">
	<h2>Sharing Objects between Fixtures<a class="headerlink" href="#sharing-objects-between-fixtures" title="Permalink to this headline">¶</a></h2>
	<p>Writing a basic fixture is simple. But what if you have multiple fixture classes
	  and want to be able to refer to the data loaded in other fixture classes?
	  For example, what if you load a <tt class="docutils literal"><span class="pre">User</span></tt> object in one fixture, and then
	  want to refer to reference it in a different fixture in order to assign that
	  user to a particular group?</p>
	<p>The Doctrine fixtures library handles this easily by allowing you to specify
	  the order in which fixtures are loaded.</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/DataFixtures/ORM/LoadUserData.php</span>
<span class="k">namespace</span> <span class="nx">Acme\HelloBundle\DataFixtures\ORM</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Doctrine\Common\DataFixtures\AbstractFixture</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Doctrine\Common\DataFixtures\OrderedFixtureInterface</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Acme\HelloBundle\Entity\User</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">LoadUserData</span> <span class="k">extends</span> <span class="nx">AbstractFixture</span> <span class="k">implements</span> <span class="nx">OrderedFixtureInterface</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">load</span><span class="p">(</span><span class="nv">$manager</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$userAdmin</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">User</span><span class="p">();</span>
        <span class="nv">$userAdmin</span><span class="o">-&gt;</span><span class="na">setUsername</span><span class="p">(</span><span class="s1">'admin'</span><span class="p">);</span>
        <span class="nv">$userAdmin</span><span class="o">-&gt;</span><span class="na">setPassword</span><span class="p">(</span><span class="s1">'test'</span><span class="p">);</span>

        <span class="nv">$manager</span><span class="o">-&gt;</span><span class="na">persist</span><span class="p">(</span><span class="nv">$userAdmin</span><span class="p">);</span>
        <span class="nv">$manager</span><span class="o">-&gt;</span><span class="na">flush</span><span class="p">();</span>

        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">addReference</span><span class="p">(</span><span class="s1">'admin-user'</span><span class="p">,</span> <span class="nv">$userAdmin</span><span class="p">);</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">getOrder</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="mi">1</span><span class="p">;</span> <span class="c1">// the order in which fixtures will be loaded</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>The fixture class now implements <tt class="docutils literal"><span class="pre">OrderedFixtureInterface</span></tt>, which tells
	  Doctrine that you want to control the order of your fixtures. Create another
	  fixture class and make it load after <tt class="docutils literal"><span class="pre">LoadUserData</span></tt> by returning an order
	  of 2:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/DataFixtures/ORM/LoadGroupData.php</span>
<span class="k">namespace</span> <span class="nx">Acme\HelloBundle\DataFixtures\ORM</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Doctrine\Common\DataFixtures\AbstractFixture</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Doctrine\Common\DataFixtures\OrderedFixtureInterface</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Acme\HelloBundle\Entity\Group</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">LoadGroupData</span> <span class="k">extends</span> <span class="nx">AbstractFixture</span> <span class="k">implements</span> <span class="nx">OrderedFixtureInterface</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">load</span><span class="p">(</span><span class="nv">$manager</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$groupAdmin</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Group</span><span class="p">();</span>
        <span class="nv">$groupAdmin</span><span class="o">-&gt;</span><span class="na">setGroupName</span><span class="p">(</span><span class="s1">'admin'</span><span class="p">);</span>

        <span class="nv">$manager</span><span class="o">-&gt;</span><span class="na">persist</span><span class="p">(</span><span class="nv">$groupAdmin</span><span class="p">);</span>
        <span class="nv">$manager</span><span class="o">-&gt;</span><span class="na">flush</span><span class="p">();</span>

        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">addReference</span><span class="p">(</span><span class="s1">'admin-group'</span><span class="p">,</span> <span class="nv">$groupAdmin</span><span class="p">);</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">getOrder</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="mi">2</span><span class="p">;</span> <span class="c1">// the order in which fixtures will be loaded</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>Both of the fixture classes extend <tt class="docutils literal"><span class="pre">AbstractFixture</span></tt>, which allows you
	  to create objects and then set them as references so that they can be used
	  later in other fixtures. For example, the <tt class="docutils literal"><span class="pre">$userAdmin</span></tt> and <tt class="docutils literal"><span class="pre">$groupAdmin</span></tt>
	  objects can be referenced later via the <tt class="docutils literal"><span class="pre">admin-user</span></tt> and <tt class="docutils literal"><span class="pre">admin-group</span></tt>
	  references:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/DataFixtures/ORM/LoadUserGroupData.php</span>
<span class="k">namespace</span> <span class="nx">Acme\HelloBundle\DataFixtures\ORM</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Doctrine\Common\DataFixtures\AbstractFixture</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Doctrine\Common\DataFixtures\OrderedFixtureInterface</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Acme\HelloBundle\Entity\UserGroup</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">LoadUserGroupData</span> <span class="k">extends</span> <span class="nx">AbstractFixture</span> <span class="k">implements</span> <span class="nx">OrderedFixtureInterface</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">load</span><span class="p">(</span><span class="nv">$manager</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$userGroupAdmin</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">UserGroup</span><span class="p">();</span>
        <span class="nv">$userGroupAdmin</span><span class="o">-&gt;</span><span class="na">setUser</span><span class="p">(</span><span class="nv">$manager</span><span class="o">-&gt;</span><span class="na">merge</span><span class="p">(</span><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">getReference</span><span class="p">(</span><span class="s1">'admin-user'</span><span class="p">)));</span>
        <span class="nv">$userGroupAdmin</span><span class="o">-&gt;</span><span class="na">setGroup</span><span class="p">(</span><span class="nv">$manager</span><span class="o">-&gt;</span><span class="na">merge</span><span class="p">(</span><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">getReference</span><span class="p">(</span><span class="s1">'admin-group'</span><span class="p">)));</span>

        <span class="nv">$manager</span><span class="o">-&gt;</span><span class="na">persist</span><span class="p">(</span><span class="nv">$userGroupAdmin</span><span class="p">);</span>
        <span class="nv">$manager</span><span class="o">-&gt;</span><span class="na">flush</span><span class="p">();</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">getOrder</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="mi">3</span><span class="p">;</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>The fixtures will now be executed in the ascending order of the value returned
	  by <tt class="docutils literal"><span class="pre">getOrder()</span></tt>. Any object that is set with the <tt class="docutils literal"><span class="pre">setReference()</span></tt> method
	  can be accessed via <tt class="docutils literal"><span class="pre">getReference()</span></tt> in fixture classes that have a higher
	  order.</p>
	<p>Fixtures allow you to create any type of data you need via the normal PHP
	  interface for creating and persisting objects. By controlling the order of
	  fixtures and setting references, almost anything can be handled by fixtures.</p>
      </div>
      <div class="section" id="using-the-container-in-the-fixtures">
	<h2>Using the Container in the Fixtures<a class="headerlink" href="#using-the-container-in-the-fixtures" title="Permalink to this headline">¶</a></h2>
	<p>In some cases you may need to access some services to load the fixtures.
	  Symfony2 makes it really easy: the container will be injected in all fixture
	  classes implementing <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/DependencyInjection/ContainerAwareInterface.html" title="Symfony\Component\DependencyInjection\ContainerAwareInterface"><span class="pre">ContainerAwareInterface</span></a></tt>.</p>
	<p>Let's rewrite the first fixture to encode the password before it's stored
	  in the database (a very good practice). This will use the encoder factory
	  to encode the password, ensuring it is encoded in the way used by the security
	  component when checking it:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/DataFixtures/ORM/LoadUserData.php</span>
<span class="k">namespace</span> <span class="nx">Acme\HelloBundle\DataFixtures\ORM</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Doctrine\Common\DataFixtures\FixtureInterface</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\ContainerAwareInterface</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\ContainerInterface</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Acme\HelloBundle\Entity\User</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">LoadUserData</span> <span class="k">implements</span> <span class="nx">FixtureInterface</span><span class="p">,</span> <span class="nx">ContainerAwareInterface</span>
<span class="p">{</span>
    <span class="k">private</span> <span class="nv">$container</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">setContainer</span><span class="p">(</span><span class="nx">ContainerInterface</span> <span class="nv">$container</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">container</span> <span class="o">=</span> <span class="nv">$container</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">load</span><span class="p">(</span><span class="nv">$manager</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$userAdmin</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">User</span><span class="p">();</span>
        <span class="nv">$userAdmin</span><span class="o">-&gt;</span><span class="na">setUsername</span><span class="p">(</span><span class="s1">'admin'</span><span class="p">);</span>
        <span class="nv">$userAdmin</span><span class="o">-&gt;</span><span class="na">setSalt</span><span class="p">(</span><span class="nb">md5</span><span class="p">(</span><span class="nb">time</span><span class="p">()));</span>

        <span class="nv">$encoder</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">container</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'security.encoder_factory'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">getEncoder</span><span class="p">(</span><span class="nv">$userAdmin</span><span class="p">);</span>
        <span class="nv">$userAdmin</span><span class="o">-&gt;</span><span class="na">setPassword</span><span class="p">(</span><span class="nv">$encoder</span><span class="o">-&gt;</span><span class="na">encodePassword</span><span class="p">(</span><span class="s1">'test'</span><span class="p">,</span> <span class="nv">$userAdmin</span><span class="o">-&gt;</span><span class="na">getSalt</span><span class="p">()));</span>

        <span class="nv">$manager</span><span class="o">-&gt;</span><span class="na">persist</span><span class="p">(</span><span class="nv">$userAdmin</span><span class="p">);</span>
        <span class="nv">$manager</span><span class="o">-&gt;</span><span class="na">flush</span><span class="p">();</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>As you can see, all you need to do is add <tt class="docutils literal"><span class="pre">ContainerAwareInterface</span></tt> to
	  the class and then create a new <tt class="docutils literal"><span class="pre">setContainer()</span></tt> method that implements
	  that interface. Before the fixture is executed, Symfony will call the <tt class="docutils literal"><span class="pre">setContainer()</span></tt>
	  method automatically. As long as you store the container as a property on
	  the class (as shown above), you can access it in the <tt class="docutils literal"><span class="pre">load()</span></tt> method.</p>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to use PHP instead of Twig for Templates" href="../templating/PHP.html">
      «&nbsp;How to use PHP instead of Twig for Templates
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to use MongoDB" href="mongodb.html">
      How to use MongoDB&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
