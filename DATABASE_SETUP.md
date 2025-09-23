# Serbian Dictionary API - Database Setup

This guide explains how to set up the database for the Serbian Dictionary API with separate tables for small and large word datasets.

## Database Structure

The API uses MySQL with UTF8MB4 charset and `utf8mb4_0900_ai_ci` collation to properly support Serbian characters.

### Tables

1. **words_small** - Basic Serbian word list (~41K words)
   - `id` (Primary Key)
   - `word` (VARCHAR 255) - Latin script word
   - `cyrillic` (VARCHAR 255) - Cyrillic script equivalent
   - `length` (INT) - Word length
   - `created_at`, `updated_at` (DATETIME)

2. **words_large** - Extended Serbian dictionary
   - Same structure as words_small
   - Contains larger dataset from `serbian-words-lat.json`

3. **names** - Serbian names with vocative forms
   - `id` (Primary Key)
   - `name` (VARCHAR 255) - Latin script name
   - `cyrillic` (VARCHAR 255) - Cyrillic script equivalent
   - `vocative` (VARCHAR 255) - Vocative form
   - `gender` (ENUM: 'male', 'female')
   - `created_at`, `updated_at` (DATETIME)

4. **surnames** - Serbian surnames
   - `id` (Primary Key)
   - `surname` (VARCHAR 255) - Latin script surname
   - `cyrillic` (VARCHAR 255) - Cyrillic script equivalent
   - `created_at`, `updated_at` (DATETIME)

## Setup Instructions

### 1. Database Configuration

Update your `.env` file with database settings:

```env
database.default.hostname = localhost
database.default.database = serbian_dictionary
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306
database.default.charset = utf8mb4
database.default.DBCollat = utf8mb4_0900_ai_ci
```

### 2. Create Database

Create the database manually in MySQL:

```sql
CREATE DATABASE serbian_dictionary 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_0900_ai_ci;
```

### 3. Run Migrations

Execute migrations to create all tables:

```bash
php spark migrate
```

This will create:
- `words_small` table
- `words_large` table
- `names` table
- `surnames` table

### 4. Run Seeders

Populate the database with data from JSON files:

#### Option A: Run all seeders at once
```bash
php spark db:seed WordsSeeder
php spark db:seed NamesSeeder
php spark db:seed SurnamesSeeder
```

#### Option B: Run individual seeders
```bash
# Small words dataset only
php spark db:seed WordsSmallSeeder

# Large words dataset only (if available)
php spark db:seed WordsLargeSeeder

# Names dataset
php spark db:seed NamesSeeder

# Surnames dataset
php spark db:seed SurnamesSeeder
```

## Data Sources

The seeders process these JSON files from `public/resources/`:

- **Small Words**: `termsSelected.json` → `words_small` table
- **Large Words**: `serbian-words-lat.json` → `words_large` table
- **Names**: `vocative.json` → `names` table
- **Surnames**: `surnames.json` → `surnames` table

## Seeder Features

### Idempotent Seeders
All seeders can be run multiple times safely:
- They truncate existing data before inserting new records
- No duplicate entries will be created

### Batch Processing
- Data is inserted in batches of 1000 records for performance
- Progress is displayed during seeding process

### Transliteration
- Latin words are automatically converted to Cyrillic using the built-in transliteration library
- Both scripts are stored in the database

### Large File Handling
- The WordsLargeSeeder checks file size before processing
- Files larger than 100MB are handled differently to prevent memory issues

## Models

The following models are available for database operations:

- `WordSmallModel` - For small words dataset
- `WordLargeModel` - For large words dataset  
- `NameModel` - For names dataset
- `SurnameModel` - For surnames dataset

## API Integration

The updated `SerbianDataService` now uses the database instead of JSON files:

- Faster queries with proper indexing
- Better filtering and pagination
- Reduced memory usage
- Support for complex queries

## Performance Considerations

### Indexes
The migrations create indexes on:
- `word` columns for fast lookups
- `length` columns for filtering
- `gender` column for names filtering

### Query Optimization
- Use specific dataset (small/large) when possible
- Implement proper pagination limits
- Use database-level random ordering for random queries

## Troubleshooting

### Common Issues

1. **Memory Issues with Large Files**
   - The large dataset seeder skips files > 100MB
   - Consider splitting large files or using streaming processing

2. **Character Encoding**
   - Ensure MySQL charset is set to `utf8mb4`
   - Verify collation is `utf8mb4_0900_ai_ci`

3. **Seeder Timeout**
   - Large datasets may take time to process
   - Monitor seeder progress output
   - Consider running small and large seeders separately

### Verification Queries

Check data after seeding:

```sql
-- Check record counts
SELECT 'words_small' as table_name, COUNT(*) as count FROM words_small
UNION ALL
SELECT 'words_large' as table_name, COUNT(*) as count FROM words_large
UNION ALL
SELECT 'names' as table_name, COUNT(*) as count FROM names
UNION ALL
SELECT 'surnames' as table_name, COUNT(*) as count FROM surnames;

-- Sample data
SELECT * FROM words_small LIMIT 5;
SELECT * FROM names WHERE gender = 'male' LIMIT 5;
```