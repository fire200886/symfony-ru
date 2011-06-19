<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to generate Entities from an Existing Database</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-generate-entities-from-an-existing-database">
      <span id="index-0"></span><h1>How to generate Entities from an Existing Database<a class="headerlink" href="#how-to-generate-entities-from-an-existing-database" title="Permalink to this headline">¶</a></h1>
      <p>When starting work on a brand new project that uses a database, two different
	situations comes naturally. In most cases, the database model is designed
	and built from scratch. Sometimes, however, you'll start with an existing and
	probably unchangeable database model. Fortunately, Doctrine comes with a bunch
	of tools to help generate model classes from your existing database.</p>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p class="last">As the <a class="reference external" href="http://www.doctrine-project.org/docs/orm/2.0/en/reference/tools.html#reverse-engineering">Doctrine tools documentation</a> says, reverse engineering is a
	    one-time process to get started on a project. Doctrine is able to convert
	    approximately 70-80% of the necessary mapping information based on fields,
	    indexes and foreign key constraints. Doctrine can't discover inverse
	    associations, inheritance types, entities with foreign keys as primary keys
	    or semantical operations on associations such as cascade or lifecycle
	    events. Some additional work on the generated entities will be necessary
	    afterwards to design each to fit your domain model specificities.</p>
      </div></div>
      <p>This tutorial assumes you're using a simple blog application with the following
	two tables: <tt class="docutils literal"><span class="pre">blog_post</span></tt> and <tt class="docutils literal"><span class="pre">blog_comment</span></tt>. A comment record is linked
	to a post record thanks to a foreign key constraint.</p>
      <div class="highlight-sql"><div class="highlight"><pre><span class="k">CREATE</span> <span class="k">TABLE</span> <span class="o">`</span><span class="n">blog_post</span><span class="o">`</span> <span class="p">(</span>
  <span class="o">`</span><span class="n">id</span><span class="o">`</span> <span class="nb">bigint</span><span class="p">(</span><span class="mi">20</span><span class="p">)</span> <span class="k">NOT</span> <span class="k">NULL</span> <span class="n">AUTO_INCREMENT</span><span class="p">,</span>
  <span class="o">`</span><span class="n">title</span><span class="o">`</span> <span class="nb">varchar</span><span class="p">(</span><span class="mi">100</span><span class="p">)</span> <span class="k">COLLATE</span> <span class="n">utf8_unicode_ci</span> <span class="k">NOT</span> <span class="k">NULL</span><span class="p">,</span>
  <span class="o">`</span><span class="n">content</span><span class="o">`</span> <span class="n">longtext</span> <span class="k">COLLATE</span> <span class="n">utf8_unicode_ci</span> <span class="k">NOT</span> <span class="k">NULL</span><span class="p">,</span>
  <span class="o">`</span><span class="n">created_at</span><span class="o">`</span> <span class="n">datetime</span> <span class="k">NOT</span> <span class="k">NULL</span><span class="p">,</span>
  <span class="k">PRIMARY</span> <span class="k">KEY</span> <span class="p">(</span><span class="o">`</span><span class="n">id</span><span class="o">`</span><span class="p">),</span>
<span class="p">)</span> <span class="n">ENGINE</span><span class="o">=</span><span class="n">InnoDB</span> <span class="n">AUTO_INCREMENT</span><span class="o">=</span><span class="mi">1</span> <span class="k">DEFAULT</span> <span class="n">CHARSET</span><span class="o">=</span><span class="n">utf8</span> <span class="k">COLLATE</span><span class="o">=</span><span class="n">utf8_unicode_ci</span><span class="p">;</span>

<span class="k">CREATE</span> <span class="k">TABLE</span> <span class="o">`</span><span class="n">blog_comment</span><span class="o">`</span> <span class="p">(</span>
  <span class="o">`</span><span class="n">id</span><span class="o">`</span> <span class="nb">bigint</span><span class="p">(</span><span class="mi">20</span><span class="p">)</span> <span class="k">NOT</span> <span class="k">NULL</span> <span class="n">AUTO_INCREMENT</span><span class="p">,</span>
  <span class="o">`</span><span class="n">post_id</span><span class="o">`</span> <span class="nb">bigint</span><span class="p">(</span><span class="mi">20</span><span class="p">)</span> <span class="k">NOT</span> <span class="k">NULL</span><span class="p">,</span>
  <span class="o">`</span><span class="n">author</span><span class="o">`</span> <span class="nb">varchar</span><span class="p">(</span><span class="mi">20</span><span class="p">)</span> <span class="k">COLLATE</span> <span class="n">utf8_unicode_ci</span> <span class="k">NOT</span> <span class="k">NULL</span><span class="p">,</span>
  <span class="o">`</span><span class="n">content</span><span class="o">`</span> <span class="n">longtext</span> <span class="k">COLLATE</span> <span class="n">utf8_unicode_ci</span> <span class="k">NOT</span> <span class="k">NULL</span><span class="p">,</span>
  <span class="o">`</span><span class="n">created_at</span><span class="o">`</span> <span class="n">datetime</span> <span class="k">NOT</span> <span class="k">NULL</span><span class="p">,</span>
  <span class="k">PRIMARY</span> <span class="k">KEY</span> <span class="p">(</span><span class="o">`</span><span class="n">id</span><span class="o">`</span><span class="p">),</span>
  <span class="k">KEY</span> <span class="o">`</span><span class="n">blog_comment_post_id_idx</span><span class="o">`</span> <span class="p">(</span><span class="o">`</span><span class="n">post_id</span><span class="o">`</span><span class="p">),</span>
  <span class="k">CONSTRAINT</span> <span class="o">`</span><span class="n">blog_post_id</span><span class="o">`</span> <span class="k">FOREIGN</span> <span class="k">KEY</span> <span class="p">(</span><span class="o">`</span><span class="n">post_id</span><span class="o">`</span><span class="p">)</span> <span class="k">REFERENCES</span> <span class="o">`</span><span class="n">blog_post</span><span class="o">`</span> <span class="p">(</span><span class="o">`</span><span class="n">id</span><span class="o">`</span><span class="p">)</span> <span class="k">ON</span> <span class="k">DELETE</span> <span class="k">CASCADE</span>
<span class="p">)</span> <span class="n">ENGINE</span><span class="o">=</span><span class="n">InnoDB</span> <span class="n">AUTO_INCREMENT</span><span class="o">=</span><span class="mi">1</span> <span class="k">DEFAULT</span> <span class="n">CHARSET</span><span class="o">=</span><span class="n">utf8</span> <span class="k">COLLATE</span><span class="o">=</span><span class="n">utf8_unicode_ci</span><span class="p">;</span>
	</pre></div>
      </div>
      <p>Before diving into the recipe, be sure your database connection parameters are
	correctly setup in the <tt class="docutils literal"><span class="pre">app/config/parameters.ini</span></tt> file (or wherever your
	database configuration is kept) and that you have initialized a bundle that
	will host your future entity class. In this tutorial, we will assume that
	an <tt class="docutils literal"><span class="pre">AcmeBlogBundle</span></tt> exists and is located under the <tt class="docutils literal"><span class="pre">src/Acme/BlogBundle</span></tt>
	folder.</p>
      <p>The first step towards building entity classes from an existing database
	is to ask Doctrine to introspect the database and generate the corresponding
	metadata files. Metadata files describe the entity class to generate based on
	tables fields.</p>
      <div class="highlight-bash"><div class="highlight"><pre>php app/console doctrine:mapping:convert xml ./src/Acme/BlogBundle/Resources/config/doctrine/metadata/orm --from-database --force
	</pre></div>
      </div>
      <p>This command line tool asks Doctrine to introspect the database and generate
	the XML metadata files under the <tt class="docutils literal"><span class="pre">src/Acme/BlogBundle/Resources/config/doctrine/metadata/orm</span></tt>
	folder of your bundle.</p>
      <div class="admonition-wrapper">
	<div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	  <p class="last">It's also possible to generate metadata class in YAML format by changing the
	    first argument to <cite>yml</cite>.</p>
      </div></div>
      <p>The generated <tt class="docutils literal"><span class="pre">BlogPost.dcm.xml</span></tt> metadata file looks as follows:</p>
      <div class="highlight-xml"><div class="highlight"><pre><span class="cp">&lt;?xml version="1.0" encoding="utf-8"?&gt;</span>
<span class="nt">&lt;doctrine-mapping&gt;</span>
  <span class="nt">&lt;entity</span> <span class="na">name=</span><span class="s">"BlogPost"</span> <span class="na">table=</span><span class="s">"blog_post"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;change-tracking-policy&gt;</span>DEFERRED_IMPLICIT<span class="nt">&lt;/change-tracking-policy&gt;</span>
    <span class="nt">&lt;id</span> <span class="na">name=</span><span class="s">"id"</span> <span class="na">type=</span><span class="s">"bigint"</span> <span class="na">column=</span><span class="s">"id"</span><span class="nt">&gt;</span>
      <span class="nt">&lt;generator</span> <span class="na">strategy=</span><span class="s">"IDENTITY"</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;/id&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">"title"</span> <span class="na">type=</span><span class="s">"string"</span> <span class="na">column=</span><span class="s">"title"</span> <span class="na">length=</span><span class="s">"100"</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">"content"</span> <span class="na">type=</span><span class="s">"text"</span> <span class="na">column=</span><span class="s">"content"</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">"isPublished"</span> <span class="na">type=</span><span class="s">"boolean"</span> <span class="na">column=</span><span class="s">"is_published"</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">"createdAt"</span> <span class="na">type=</span><span class="s">"datetime"</span> <span class="na">column=</span><span class="s">"created_at"</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">"updatedAt"</span> <span class="na">type=</span><span class="s">"datetime"</span> <span class="na">column=</span><span class="s">"updated_at"</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;field</span> <span class="na">name=</span><span class="s">"slug"</span> <span class="na">type=</span><span class="s">"string"</span> <span class="na">column=</span><span class="s">"slug"</span> <span class="na">length=</span><span class="s">"255"</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;lifecycle-callbacks/&gt;</span>
  <span class="nt">&lt;/entity&gt;</span>
<span class="nt">&lt;/doctrine-mapping&gt;</span>
	</pre></div>
      </div>
      <p>Once the metadata files are generated, you can ask Doctrine to import the
	schema and build related entity classes by executing the following two commands.</p>
      <div class="highlight-bash"><div class="highlight"><pre><span class="nv">$ </span>php app/console doctrine:mapping:import AcmeBlogBundle annotation
<span class="nv">$ </span>php app/console doctrine:generate:entities AcmeBlogBundle
	</pre></div>
      </div>
      <p>The first command generates entity classes with an annotations mapping, but
	you can of course change the <tt class="docutils literal"><span class="pre">annotation</span></tt> argument to <tt class="docutils literal"><span class="pre">xml</span></tt> or <tt class="docutils literal"><span class="pre">yml</span></tt>.
	The newly created <tt class="docutils literal"><span class="pre">BlogComment</span></tt> entity class looks as follow:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="o">&lt;?</span><span class="nx">php</span>

<span class="c1">// src/Acme/BlogBundle/Entity/BlogComment.php</span>
<span class="k">namespace</span> <span class="nx">Acme\BlogBundle\Entity</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Doctrine\ORM\Mapping</span> <span class="k">as</span> <span class="nx">ORM</span><span class="p">;</span>

<span class="sd">/**</span>
<span class="sd"> * Acme\BlogBundle\Entity\BlogComment</span>
<span class="sd"> *</span>
<span class="sd"> * @ORM\Table(name="blog_comment")</span>
<span class="sd"> * @ORM\Entity</span>
<span class="sd"> */</span>
<span class="k">class</span> <span class="nc">BlogComment</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @var bigint $id</span>
<span class="sd">     *</span>
<span class="sd">     * @ORM\Column(name="id", type="bigint", nullable=false)</span>
<span class="sd">     * @ORM\Id</span>
<span class="sd">     * @ORM\GeneratedValue(strategy="IDENTITY")</span>
<span class="sd">     */</span>
    <span class="k">private</span> <span class="nv">$id</span><span class="p">;</span>

    <span class="sd">/**</span>
<span class="sd">     * @var string $author</span>
<span class="sd">     *</span>
<span class="sd">     * @ORM\Column(name="author", type="string", length=100, nullable=false)</span>
<span class="sd">     */</span>
    <span class="k">private</span> <span class="nv">$author</span><span class="p">;</span>

    <span class="sd">/**</span>
<span class="sd">     * @var text $content</span>
<span class="sd">     *</span>
<span class="sd">     * @ORM\Column(name="content", type="text", nullable=false)</span>
<span class="sd">     */</span>
    <span class="k">private</span> <span class="nv">$content</span><span class="p">;</span>

    <span class="sd">/**</span>
<span class="sd">     * @var datetime $createdAt</span>
<span class="sd">     *</span>
<span class="sd">     * @ORM\Column(name="created_at", type="datetime", nullable=false)</span>
<span class="sd">     */</span>
    <span class="k">private</span> <span class="nv">$createdAt</span><span class="p">;</span>

    <span class="sd">/**</span>
<span class="sd">     * @var BlogPost</span>
<span class="sd">     *</span>
<span class="sd">     * @ORM\ManyToOne(targetEntity="BlogPost")</span>
<span class="sd">     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")</span>
<span class="sd">     */</span>
    <span class="k">private</span> <span class="nv">$post</span><span class="p">;</span>
<span class="p">}</span>
	</pre></div>
      </div>
      <p>As you can see, Doctrine converts all table fields to pure private and annotated
	class properties. The most impressive thing is that it also discovered the
	relationship with the <tt class="docutils literal"><span class="pre">BlogPost</span></tt> entity class based on the foreign key constraint.
	Consequently, you can find a private <tt class="docutils literal"><span class="pre">$post</span></tt> property mapped with a <tt class="docutils literal"><span class="pre">BlogPost</span></tt>
	entity in the <tt class="docutils literal"><span class="pre">BlogComment</span></tt> entity class.</p>
      <p>The last command generated all getters and setters for your two <tt class="docutils literal"><span class="pre">BlogPost</span></tt> and
	<tt class="docutils literal"><span class="pre">BlogComment</span></tt> entity class properties. The generated entities are now ready to be
	used. Have fun!</p>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Registering Event Listeners and Subscribers" href="event_listeners_subscribers.html">
      «&nbsp;Registering Event Listeners and Subscribers
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to use Doctrine's DBAL Layer" href="dbal.html">
      How to use Doctrine's DBAL Layer&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
