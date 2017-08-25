Doctrine Stale Entity Demo
=

This is a simple demo using the default Doctrine2 setup that shows an issue
where stale entities can be loaded.

The problem arises when an entity is fetched before a transaction that
re-fetches the same entity for update later. Because the entity is already in
the cache, the stale values are hydrated even though the actual query returned
the latest correct data.

Setup
-

- `$ composer install`
- Create MySQL database
- Import `assets/db-dump.sql` into the database
- Update connection config on lines 11-13

Test Setup
-

 - `php -S localhost:8000 -t public/`
 - Load `http://localhost:8000/` in your browser
 
 You should see a dump of `UserModel`:
 
 ![Model Data](https://raw.github.com/shauno/doctrine-stale-demo/master/assets/user-id-1.png)
 
 Replicate the issue
 -
 
 To replicate the issue we need competing requests trying to lock the same
 record. MySQL handles this fine and will queue the requests up as they come
 in.
 
 Open your MySQL client tools and run the following queries on the database:
 
 ```mysql
 start transaction;
 select * from users where id = 1 for update;
 update users set age = 35 where id = 1;
 ```
 
 ![MySQL Client](https://raw.github.com/shauno/doctrine-stale-demo/master/assets/mysql-client.png)
 
 Refresh your browser. The page should hang waiting to get a lock on the same
 row already locked by your MySQL client.
 
 Now commit the transaction in your MySQL client:
 
 ![MySQL Client Commit](https://raw.github.com/shauno/doctrine-stale-demo/master/assets/mysql-commit.png)
 
 The page should complete loading, but with stale data:
 
 ![Stale Model Data](https://raw.github.com/shauno/doctrine-stale-demo/master/assets/user-id-1.png)

Even though the code waited on the lock, and the actual query returned the
updated record (age = 35), because the entity was loaded previously `$user`
will be hydrated with the "stale" data.