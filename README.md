# Restaurants Home Assignment

Laravel-based web app for browsing currently opened restaurants.

## Assignment

- [x] Given the attached CSV data files, write an artisan command/function importData, that will import data from CSVs to DB.
- [x] Create MVC to display imported data from DB
  - [x] The default view should display the currently opened restaurant
  - [x] We want to be able to search in restaurants (even closed ones)

## Installation

**Note**: You may use `Makefile` to run all these steps `make install`

Install composer & node dependencies:

```shell
composer install
npm install
```

Configure Laravel:

```shell
cp .env.example .env
php artisan key:generate
```

Compile assets:

```shell
npm run develop
```

## Development

Start docker containers:

```shell
docker-compose up -d
```

Once docker is bootstrapped the website will be available at: http://restaurants.localtest.me/ (no /etc/hosts magic required).

**Note**: You may use `Makefile` to start docker `make up`

Stop docker containers:

```shell
docker-compose up -d
```

**Note**: You may use `Makefile` to stop docker `make down`

Apply migrations:

```shell
docker-compose exec -T -u nobody backend php artisan migrate
```

**Note**: You may use `Makefile` to stop docker `make migrate`

Import data:

```shell
docker-compose exec -T -u nobody backend php artisan data:import restaurants-hours-source-1.csv -H
docker-compose exec -T -u nobody backend php artisan data:import restaurants-hours-source-2.csv
```

**Note**: You may use `Makefile` to stop docker `make import`

## Features

- Personally I like to use `Makefile` for my projects and extract commonly used commands in there;
- There's a proper CI setup present within this repo, we check for code standards (phpcs, static analysis (phpstan), and unit test (phpunit);
- For data import I quickly scaffold sort of strategy pattern that determines which data transformer should be applied, would be easier to extend/refactor in the future;
- For data import I used DTOs to normalise data into consumable objects before importing;
- The whole import feature is within `app/Import` so it would be mentally easier to work with instead of spreading classes across the project folders;
- All the query scopes for models are extracted into a proper dedicated classes, that gives us a better readability/testability(is that a word?) so your model classes doesn't become "fat";
- I also used Livewire to quickly display the results without even writing a single line of JS, it performs real time search/filtering without browser refresh
- All the written code is tested using feature and unit tests;
- I went for a quick unique index (restaurant_id, weekday) for 'schedules' table, it wouldn't cover the whole where condition, but it does the job, given low cardinality without doing any filesort etc

## Considerations

Given limited time, I would play around wih the following:

- CSV batch import or even splitting the load with queued jobs
- DB query builder for importing data instead of proper models
- Wrap import into DB transaction
- Consider using clustered primary key for 'schedules' table, that would ensure that records are stored closed to each other when queried, however that would probably slow down the inserts so it depends on what we want to achieve with this app
- I would probably revisit my DTOs and refactor a few things in there, for instance, extract all this parsing logic into dedicated classes
- I would probably use a proper join when querying currently open restaurants, that might give a bit of boost, but given amount of data current implementation performs well
- I would probably revisit the way I store/query open & close times, I was thinking it might be easier to query when we store the opening time duration as integer
