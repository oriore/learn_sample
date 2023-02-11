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