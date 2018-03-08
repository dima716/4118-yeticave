<p>Пожалуйста, создайте в папке config файл db.php, указав в нем необходимые данные для доступа к
  бд:</p>

<p>host - адрес, где находится сервер,</br>
  user - имя пользователя для подключения,</br>
  password - пароль пользователя,</br>
  database - имя базы данных для работы</p>

<p>Пример файла:</p>

<code>
  &lt;?php
  return [</br>
  &quot;host&quot; =&gt; &quot;localhost&quot;,</br>
  &quot;user&quot; =&gt; &quot;root&quot;,</br>
  &quot;password&quot; =&gt; &quot;password&quot;,</br>
  &quot;database&quot; =&gt; &quot;yeticave&quot;</br>
  ];
</code>
