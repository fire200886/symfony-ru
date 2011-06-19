<div class="related">
    <h2>Новости</h2>
 <div style="width:60%;padding-bottom: 10%">
    <script src="http://widgets.twimg.com/j/2/widget.js"></script>
<script>
new TWTR.Widget({
  version: 2,
  type: 'profile',
  rpp: 4,
  interval: 6000,
  width: 'auto',
  height: 300,
  theme: {
    shell: {
      background: '#303030',
      color: '#ffffff'
    },
    tweets: {
      background: '#ffffff',
      color: '#505050',
      links: '#0080c0'
    }
  },
  features: {
    scrollbar: true,
    loop: false,
    live: false,
    hashtags: true,
    timestamp: true,
    avatars: false,
    behavior: 'all'
  }
}).render().setUser('Symfonyru').start();
</script>
</div>
</div>

<div class="unrelated">
    <h3>
        Symfony - это PHP-фреймворк для создания веб-приложений.
    </h3>

    <p>
        Повысь скорость разработки и поддержки своих веб-приложений. Замени повторяющиеся задачи мощью, контролем и удовольствием.
    </p>

    <ul class="big2 green buttons">
        <li>
            <a href="http://symfony.com/download">
                Скачать
            </a>
        </li>
    </ul>
    
    
	<div>
		<h2>Быстрый старт</h2>

		<p>
			<ul>
		    <li><a href="<?php l('why-use-a-framework')?>">Почему я должен использовать фреймворк?</a></li>
		    <li><a href="<?php l('six-good-reasons')?>">6 причин использовать Symfony</a></li>
		    <li><a href="<?php l('doc/quick_tour/the_big_picture')?>">Быстрый старт</a></li>
		    </ul>
		</p>

	</div>
	
		<div>
		<h2>Нужна ваша помощь</h2>

		<p>
			В данный момент активно переводится документация, но с
			вашей помощью дело может идти в разы быстрее.<br/>
			Так же приветствуется написание статей и уроков по Symfony2.<br/>
			Для связи вы можете воспользоваться <a href="<?php l('help')?>">формой</a> или <a href="/forum/">форумом</a>.
		</p>

	</div>
</div>
