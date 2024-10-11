# atte(勤怠管理システム)
ユーザの勤怠を管理する。
![image](https://github.com/user-attachments/assets/424d5e78-4135-429c-909d-72f35d661cfd)

## 作成した目的
-人事評価

## 機能一覧
-会員登録
-ログイン
-ログアウト
-勤務開始
-勤務終了
-休憩開始
-休憩終了
-日付別勤怠情報取得
-ユーザ別勤怠情報取得
-全ユーザ情報取得
-ページネーション
-メール認証
## テーブル設計
![image](https://github.com/user-attachments/assets/2c2af988-904a-4979-b0f4-f949c7679fd8)

## ER図
![image](https://github.com/user-attachments/assets/79430db2-cb22-4d3e-9b3e-4149d2908ae6)

## 環境構築
**Dockerビルド**
1. `git clone git@github.com:estra-inc/confirmation-test-contact-form.git`
2. DockerDesktopアプリを立ち上げる
3. `docker-compose up -d --build`

> *MacのM1・M2チップのPCの場合、`no matching manifest for linux/arm64/v8 in the manifest list entries`のメッセージが表示されビルドができないことがあります。
エラーが発生する場合は、docker-compose.ymlファイルの「mysql」内に「platform」の項目を追加で記載してください*
``` bash
mysql:
    platform: linux/x86_64(この文追加)
    image: mysql:8.0.26
    environment:
```

**Laravel環境構築**
1. `docker-compose exec php bash`
2. `composer install`
3. 「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.envファイルを作成
4. .envに以下の環境変数を追加
``` text
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass

MAIL_FROM_ADDRESS=test@icloud.com
```
5. アプリケーションキーの作成
``` bash
php artisan key:generate
```

6. マイグレーションの実行
``` bash
php artisan migrate
```

## 使用技術(実行環境)
- PHP8.3.0
- Laravel8.83.27
- MySQL8.0.26

## URL
- 開発環境：http://localhost/
- phpMyAdmin:：http://localhost:8080/
- mailhog::http://localhost:8025/