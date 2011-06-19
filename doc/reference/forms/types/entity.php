<?php include(__DIR__.'/../../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">entity Field Type</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="entity-field-type">
      <span id="index-0"></span><h1>entity Field Type<a class="headerlink" href="#entity-field-type" title="Permalink to this headline">¶</a></h1>
      <p>A special <tt class="docutils literal"><span class="pre">choice</span></tt> field that's designed to load options from a Doctrine
	entity. For example, if you have a <tt class="docutils literal"><span class="pre">Category</span></tt> entity, you could use this
	field to display a <tt class="docutils literal"><span class="pre">select</span></tt> field of all, or some, of the <tt class="docutils literal"><span class="pre">Category</span></tt>
	objects from the database.</p>
      <table border="1" class="docutils">
	<colgroup>
	  <col width="25%">
	  <col width="75%">
	</colgroup>
	<tbody valign="top">
	  <tr><td>Underlying Data Type</td>
	    <td>An array of entity "identifiers" (e.g. an array of selected ids)</td>
	  </tr>
	  <tr><td>Rendered as</td>
	    <td>can be various tags (see <a class="reference internal" href="choice.html#forms-reference-choice-tags"><em>Select tag, Checkboxes or Radio Buttons</em></a>)</td>
	  </tr>
	  <tr><td>Options</td>
	    <td><ul class="first last simple">
		<li><tt class="docutils literal"><span class="pre">class</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">property</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">query_builder</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">multiple</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">expanded</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">preferred_choices</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">required</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">label</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">read_only</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">error_bubbling</span></tt></li>
	      </ul>
	    </td>
	  </tr>
	  <tr><td>Parent type</td>
	    <td><a class="reference internal" href="choice.html"><em>choice</em></a></td>
	  </tr>
	  <tr><td>Class</td>
	    <td><tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/SymfonyBridgeDoctrineFormType/EntityType.html" title="SymfonyBridgeDoctrineFormType\EntityType"><span class="pre">EntityType</span></a></tt></td>
	  </tr>
	</tbody>
      </table>
      <div class="section" id="basic-usage">
	<h2>Basic Usage<a class="headerlink" href="#basic-usage" title="Permalink to this headline">¶</a></h2>
	<p>The <tt class="docutils literal"><span class="pre">entity</span></tt> type has just one required option: the entity which should
	  be listed inside the choice field:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$builder</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'users'</span><span class="p">,</span> <span class="s1">'entity'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'class'</span> <span class="o">=&gt;</span> <span class="s1">'Acme\\HelloBundle\\Entity\\User'</span><span class="p">,</span>
<span class="p">));</span>
	  </pre></div>
	</div>
	<p>In this case, all <tt class="docutils literal"><span class="pre">User</span></tt> objects will be loaded from the database and rendered
	  as either a <tt class="docutils literal"><span class="pre">select</span></tt> tag, a set or radio buttons or a series of checkboxes
	  (this depends on the <tt class="docutils literal"><span class="pre">multiple</span></tt> and <tt class="docutils literal"><span class="pre">expanded</span></tt> values).</p>
	<div class="section" id="using-a-custom-query-for-the-entities">
	  <h3>Using a Custom Query for the Entities<a class="headerlink" href="#using-a-custom-query-for-the-entities" title="Permalink to this headline">¶</a></h3>
	  <p>If you need to specify a custom query to use when fetching the entities (e.g.
	    you only want to return some entities, or need to order them), use the <tt class="docutils literal"><span class="pre">query_builder</span></tt>
	    option. The easiest way to use the option is as follows:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Doctrine\ORM\EntityRepository</span><span class="p">;</span>
<span class="c1">// ...</span>

<span class="nv">$builder</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'users'</span><span class="p">,</span> <span class="s1">'entity'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'class'</span> <span class="o">=&gt;</span> <span class="s1">'Acme\\HelloBundle\\Entity\\User'</span><span class="p">,</span>
    <span class="s1">'query_builder'</span> <span class="o">=&gt;</span> <span class="k">function</span><span class="p">(</span><span class="nx">EntityRepository</span> <span class="nv">$er</span><span class="p">)</span> <span class="p">{</span>
        <span class="k">return</span> <span class="nv">$er</span><span class="o">-&gt;</span><span class="na">createQueryBuilder</span><span class="p">(</span><span class="s1">'u'</span><span class="p">)</span>
            <span class="o">-&gt;</span><span class="na">orderBy</span><span class="p">(</span><span class="s1">'u.username'</span><span class="p">,</span> <span class="s1">'ASC'</span><span class="p">);</span>
    <span class="p">},</span>
<span class="p">));</span>
	    </pre></div>
	  </div>
	</div>
      </div>
      <div class="section" id="select-tag-checkboxes-or-radio-buttons">
	<h2>Select tag, Checkboxes or Radio Buttons<a class="headerlink" href="#select-tag-checkboxes-or-radio-buttons" title="Permalink to this headline">¶</a></h2>
	<p>This field may be rendered as one of several different HTML fields, depending
	  on the <tt class="docutils literal"><span class="pre">expanded</span></tt> and <tt class="docutils literal"><span class="pre">multiple</span></tt> options:</p>
	<table border="1" class="docutils">
	  <colgroup>
	    <col width="68%">
	    <col width="16%">
	    <col width="16%">
	  </colgroup>
	  <thead valign="bottom">
	    <tr><th class="head">element type</th>
	      <th class="head">expanded</th>
	      <th class="head">multiple</th>
	    </tr>
	  </thead>
	  <tbody valign="top">
	    <tr><td>select tag</td>
	      <td>false</td>
	      <td>false</td>
	    </tr>
	    <tr><td>select tag (with <tt class="docutils literal"><span class="pre">multiple</span></tt> attribute)</td>
	      <td>false</td>
	      <td>true</td>
	    </tr>
	    <tr><td>radio buttons</td>
	      <td>true</td>
	      <td>false</td>
	    </tr>
	    <tr><td>checkboxes</td>
	      <td>true</td>
	      <td>true</td>
	    </tr>
	  </tbody>
	</table>
      </div>
      <div class="section" id="adding-an-empty-value">
	<h2>Adding an "empty value"<a class="headerlink" href="#adding-an-empty-value" title="Permalink to this headline">¶</a></h2>
	<p>If you're using the non-expanded version of the type (i.e. a <tt class="docutils literal"><span class="pre">select</span></tt> tag)
	  element and you'd like to have a blank entry (e.g. "Choose an option") at
	  the top of the select box, you can easily do so by doing the following:</p>
	<ul class="simple">
	  <li>Set the <tt class="docutils literal"><span class="pre">multiple</span></tt> option to false;</li>
	  <li>Set the <tt class="docutils literal"><span class="pre">required</span></tt> option to false or explicitly pass in the <tt class="docutils literal"><span class="pre">empty_value</span></tt>
	    option in the template (as shown below).</li>
	</ul>
	<p>If <tt class="docutils literal"><span class="pre">required</span></tt> is false, a blank choice will display at the top of the select
	  box. To customize what that entry says (or if you have <tt class="docutils literal"><span class="pre">required</span></tt> set to
	  <tt class="docutils literal"><span class="pre">true</span></tt>), add the following when rendering the field:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 76px; ">
	    <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="cp">{{</span> <span class="nv">form_widget</span><span class="o">(</span><span class="nv">form.foo_choices</span><span class="o">,</span> <span class="o">{</span> <span class="s1">'empty_value'</span><span class="o">:</span> <span class="s1">'Choose an option'</span> <span class="o">})</span> <span class="cp">}}</span><span class="x"></span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="o">&lt;?</span><span class="nx">php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">widget</span><span class="p">(</span><span class="nv">$form</span><span class="p">[</span><span class="s1">'foo_choices'</span><span class="p">],</span> <span class="k">array</span><span class="p">(</span><span class="s1">'empty_value'</span> <span class="o">=&gt;</span> <span class="s1">'Choose an option'</span><span class="p">))</span> <span class="cp">?&gt;</span><span class="x"></span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
      <div class="section" id="options">
	<h2>Options<a class="headerlink" href="#options" title="Permalink to this headline">¶</a></h2>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">class</span></tt> <strong>required</strong> [type: string]</dt>
	      <dd><p class="first last">The class of your entity (e.g. <tt class="docutils literal"><span class="pre">Acme\StoreBundle\Entity\Category</span></tt>).</p>
	      </dd>
	    </dl>
	  </li>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">property</span></tt> [type: string]</dt>
	      <dd><p class="first last">This is the property that should be used for displaying the entities
		  as text in the HTML element. If left blank, the entity object will be
		  cast into a string and so must have a <tt class="docutils literal"><span class="pre">__toString()</span></tt> method.</p>
	      </dd>
	    </dl>
	  </li>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">query_builder</span></tt> [type: <tt class="docutils literal"><span class="pre">Doctrine\ORM\QueryBuilder</span></tt> or a Closure]</dt>
	      <dd><p class="first last">If specified, this is used to query the subset of options (and their
		  order) that should be used for the field. The value of this option can
		  either be a <tt class="docutils literal"><span class="pre">QueryBuilder</span></tt> object or a Closure. If using a Closure,
		  it should take a single argument, which is the <tt class="docutils literal"><span class="pre">EntityRepository</span></tt> of
		  the entity.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">multiple</span></tt> [type: Boolean, default: false]</dt>
	      <dd><p class="first last">If true, the user will be able to select multiple options (as opposed
		  to choosing just one option). Depending on the value of the <tt class="docutils literal"><span class="pre">expanded</span></tt>
		  option, this will render either a select tag or checkboxes if true and
		  a select tag or radio buttons if false.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">expanded</span></tt> [type: Boolean, default: false]</dt>
	      <dd><p class="first last">If set to true, radio buttons or checkboxes will be rendered (depending
		  on the <tt class="docutils literal"><span class="pre">multiple</span></tt> value). If false, a select element will be rendered.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">preferred_choices</span></tt> [type: array]</dt>
	      <dd><p class="first">If this option is specified, then a sub-set of the total number of options
		  will be moved to the top of the select menu. The following would move
		  the "Baz" option to the top, with a visual separator between it and the
		  rest of the options:</p>
		<div class="highlight-php"><div class="highlight"><pre><span class="nv">$builder</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'foo_choices'</span><span class="p">,</span> <span class="s1">'choice'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'choices'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'foo'</span> <span class="o">=&gt;</span> <span class="s1">'Foo'</span><span class="p">,</span> <span class="s1">'bar'</span> <span class="o">=&gt;</span> <span class="s1">'Bar'</span><span class="p">,</span> <span class="s1">'baz'</span> <span class="o">=&gt;</span> <span class="s1">'Baz'</span><span class="p">),</span>
    <span class="s1">'preferred_choices'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'baz'</span><span class="p">),</span>
<span class="p">));</span>
		  </pre></div>
		</div>
		<p>Note that preferred choices are only meaningful when rendering as a
		  <tt class="docutils literal"><span class="pre">select</span></tt> element (i.e. <tt class="docutils literal"><span class="pre">expanded</span></tt> is false). The preferred choices
		  and normal choices are separated visually by a set of dotted lines
		  (i.e. <tt class="docutils literal"><span class="pre">-------------------</span></tt>). This can be customized when rendering
		  the field:</p>
		<div class="last configuration-block jsactive clearfix">
		  <ul class="simple" style="height: 76px; ">
		    <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="cp">{{</span> <span class="nv">form_widget</span><span class="o">(</span><span class="nv">form.foo_choices</span><span class="o">,</span> <span class="o">{</span> <span class="s1">'separator'</span><span class="o">:</span> <span class="s1">'====='</span> <span class="o">})</span> <span class="cp">}}</span><span class="x"></span>
			</pre></div>
		      </div>
		    </li>
		    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="o">&lt;?</span><span class="nx">php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">widget</span><span class="p">(</span><span class="nv">$form</span><span class="p">[</span><span class="s1">'foo_choices'</span><span class="p">],</span> <span class="k">array</span><span class="p">(</span><span class="s1">'separator'</span> <span class="o">=&gt;</span> <span class="s1">'====='</span><span class="p">))</span> <span class="cp">?&gt;</span><span class="x"></span>
			</pre></div>
		      </div>
		    </li>
		  </ul>
		</div>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">required</span></tt> [type: Boolean, default: true]</dt>
	      <dd><p class="first last">The <tt class="docutils literal"><span class="pre">required</span></tt> option can be used to render an <a class="reference external" href="http://diveintohtml5.org/forms.html">HTML5 required attribute</a>.
		  Note that this is independent from validation: if you include the required
		  attribute on the field type but omit any required validation, the object
		  will appear to be valid to your application with a blank value. In other
		  words, this is a <em>nice</em> feature that will add client-side validation for
		  browsers that support HTML5. It's not, however, a replacement for true
		  server-side validation.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">label</span></tt> [type: string]</dt>
	      <dd><p class="first">Sets the label that will be used when rendering the field. If blank,
		  the label will be auto-generated based on the name of the field. The label
		  can also be directly set inside the template:</p>
		<div class="last highlight-jinja"><div class="highlight"><pre><span class="cp">{{</span> <span class="nv">render_label</span><span class="o">(</span><span class="nv">form.name</span><span class="o">,</span> <span class="s1">'Name'</span><span class="o">)</span> <span class="cp">}}</span><span class="x"></span>
		  </pre></div>
		</div>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">read_only</span></tt> [type: Boolean, default: false]</dt>
	      <dd><p class="first last">If this option is true, the field will be rendered with the <tt class="docutils literal"><span class="pre">disabled</span></tt>
		  attribute so that the field is not editable.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">error_bubbling</span></tt> [type: Boolean, default: false]</dt>
	      <dd><p class="first last">If true, any errors for this field will be passed to the parent field
		  or form. For example, if set to true on a normal field, any errors for
		  that field will be attached to the main form, not to the specific field.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="email Field Type" href="email.html">
      «&nbsp;email Field Type
    </a><span class="separator">|</span>
    <a accesskey="N" title="file Field Type" href="file.html">
      file Field Type&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
