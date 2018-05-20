      <div class="row marketing">
        <div class="col-lg-12">
		  
<?php  if($this->data['admin']==-1){ ?>

          <div class="alert alert-danger alert-dismissible" id="myAlert">
            <a href="#" class="close">&times;</a>
            <strong>Ошибка.</strong> Не верный логин или пароль.
          </div>

<?php }; ?>
		  
          <h4>Админка</h4>

		  <?php  if($this->data['admin'] < 1){ ?>

          <form action="/admin" method="post">
            <div class="form-group">
              <label for="user">Имя пользователя:</label>
              <input type="text" class="form-control" id="user" placeholder="Введите имя пользователя..." required="true" name="user">
            </div>
            <div class="form-group">
              <label for="password">Пароль:</label>
              <input type="password" class="form-control" id="password" placeholder="Введите пароль..." required="true" name="password">
            </div>
            <button type="submit" class="btn btn-default">Войти</button>
          </form>		  

<?php }; ?>


<?php  if($this->data['admin'] == 1){ ?>
          <p>Вы зашли как <strong>Администратор</strong>.</p>

          <form action="/admin" method="post">
            <button type="submit" class="btn btn-default" name="logout">Выйти</button>
          </form>		  

<?php }; ?>

		  	  
        </div>
      </div>
