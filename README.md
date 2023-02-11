# learn_sample
## 立ち上げ
```
docker-compose up -d 
```

## URL
### sqlインジェクションの確認
初期作成されるuserテーブルに対して部分一致検索を行うだけのフォーム画面があります。
```
・sqlインジェクションが起きるURL
http://localhost:8081/mysql/

・修正したURL
http://localhost:8081/mysql/fix
```

## XSSの確認
文字列を入力できるフォームがあり、サブミットするとその内容が表示される画面があります。
下記のような入力をする画面に表示されるリンクを押した時にアラートが出力されます。
```html
<a href=javascript:alert("XSS");>URLです</a>
```
```
・sqlインジェクションが起きるURL
http://localhost:8081/xss/

・修正したURL
http://localhost:8081/xss/fix
```