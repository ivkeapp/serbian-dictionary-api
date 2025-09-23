# Serbian Dictionary API

A comprehensive CodeIgniter4 API that serves Serbian words, names, and surnames with transliteration support between Latin and Cyrillic scripts. The API offers two implementations: a high-performance database-backed version and a lightweight JSON file-based version.

## Features

- **Dual Implementation**: Database-backed (fast) and JSON file-based (portable)
- **Massive Dataset**: Support for 2.8M+ words in extended dictionary
- **Words API**: Access basic word lists or extended dictionary
- **Names API**: Serbian names with gender information and vocative forms
- **Surnames API**: Serbian surnames database
- **Transliteration**: Convert between Latin and Cyrillic scripts
- **Text Converter**: Interactive web interface for live Latin ↔ Cyrillic conversion
- **Advanced Filtering**: Search by text, length, gender, and more
- **Pagination**: Efficient pagination for all endpoints
- **Random Entries**: Get random words, names, or surnames

## Installation

### Basic Setup

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd serbian-dictionary-api
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Set up environment**
   ```bash
   cp env .env
   ```
   
   Edit `.env` file and configure:
   ```env
   CI_ENVIRONMENT = development
   app.baseURL = 'http://localhost:8080'
   
   # Database configuration (for database API)
   database.default.hostname = localhost
   database.default.database = serbian_dictionary
   database.default.username = root
   database.default.password = 
   database.default.DBDriver = MySQLi
   database.default.charset = utf8mb4
   database.default.DBCollat = utf8mb4_0900_ai_ci
   ```

4. **Start the development server**
   ```bash
   php spark serve
   ```

### Database Setup (Optional - for high-performance API)

1. **Create database**
   ```sql
   CREATE DATABASE serbian_dictionary 
   CHARACTER SET utf8mb4 
   COLLATE utf8mb4_0900_ai_ci;
   ```

2. **Run migrations**
   ```bash
   php spark migrate
   ```

3. **Seed the database**
   ```bash
   php spark db:seed WordsSmallSeeder
   php spark db:seed WordsLargeSeeder
   php spark db:seed NamesSeeder
   php spark db:seed SurnamesSeeder
   ```

The API will be available at `http://localhost:8080`

## API Implementations

### Database API (Recommended) - `/api/*`

**Base URL**: `http://localhost:8080/api/`

#### **Features:**
- **Fast**: Indexed database queries
- **Scalable**: Handles 2.8M+ records efficiently  
- **Memory efficient**: Streaming results
- **Complex queries**: Advanced filtering support
- **Production ready**: Optimized for high-traffic applications

#### **Dataset Sizes:**
- **Small Words**: 41,170 basic Serbian words
- **Large Words**: 2,788,818 extended dictionary words
- **Names**: 1,808 Serbian names with vocative forms
- **Surnames**: 7,987 Serbian surnames

### JSON File API (Legacy) - `/api-old/*`

**Base URL**: `http://localhost:8080/api-old/`

#### **Features:**
- **Simple**: No database setup required
- **Portable**: Works anywhere with JSON files
- **Lightweight**: Perfect for smaller deployments
- **Backward compatible**: Maintains existing functionality

## API Endpoints

Both implementations support identical endpoints with the same parameters:

### Words

**GET /api/words** | **GET /api-old/words**
- Get paginated list of words
- **Query parameters:**
  - `dataset=small|large` (default: small)
  - `script=latin|cyrillic` (default: latin)
  - `starts_with=ab` (optional)
  - `contains=č` (optional)
  - `length=5` (optional)
  - `min_length=3` (optional)
  - `max_length=10` (optional)
  - `random=true|false` (default: false)
  - `page=1` (default: 1)
  - `limit=50` (default: 50)

**GET /api/words/{word}** | **GET /api-old/words/{word}**
- Get details for a specific word

### Names

**GET /api/names** | **GET /api-old/names**
- Get paginated list of names
- **Query parameters:**
  - `gender=male|female|all` (default: all)
  - `starts_with=M` (optional)
  - `random=true|false` (default: false)
  - `with_vocative=true|false` (default: false)
  - `page=1` (default: 1)
  - `limit=50` (default: 50)

**GET /api/names/{name}** | **GET /api-old/names/{name}**
- Get details for a specific name

### Surnames

**GET /api/surnames** | **GET /api-old/surnames**
- Get paginated list of surnames
- **Query parameters:**
  - `starts_with=Ž` (optional)
  - `random=true|false` (default: false)
  - `page=1` (default: 1)
  - `limit=50` (default: 50)

**GET /api/surnames/{surname}** | **GET /api-old/surnames/{surname}**
- Get details for a specific surname

### Helper Endpoints

**GET /api/transliterate** | **GET /api-old/transliterate**
- Convert text between Latin and Cyrillic
- **Query parameters:**
  - `text=Zdravo` (required)
  - `to=cyrillic|latin` (optional, auto-detects if not provided)

**GET /api/random** | **GET /api-old/random**
- Get random entry from dataset
- **Query parameters:**
  - `type=word|name|surname` (required)

## Response Examples

### Database API Response
```json
{
    "data": [
        {
            "word": "abdikacija",
            "latin": "abdikacija",
            "cyrillic": "абдикација",
            "length": "10"
        }
    ],
    "pagination": {
        "current_page": 1,
        "per_page": 20,
        "total_items": 41170,
        "total_pages": 2059,
        "has_next_page": true,
        "has_prev_page": false
    }
}
```

### JSON API Response
```json
{
    "data": [
        {
            "word": "abdikacija",
            "latin": "abdikacija",
            "cyrillic": "абдикација",
            "length": 10,
            "source": "json"
        }
    ],
    "pagination": {
        "current_page": 1,
        "per_page": 20,
        "total_items": 41170,
        "total_pages": 2059,
        "has_next_page": true,
        "has_prev_page": false
    }
}
```

### Name Response
```json
{
  "success": true,
  "data": {
    "name": "Miloš",
    "gender": "male",
    "latin": "Miloš",
    "cyrillic": "Милош",
    "vocative": "Miloše",
    "vocative_latin": "Miloše",
    "vocative_cyrillic": "Милоше"
  }
}
```

### Transliteration Response
```json
{
  "success": true,
  "data": {
    "original": "Zdravo",
    "transliterated": "Здраво",
    "original_script": "latin",
    "latin": "Zdravo",
    "cyrillic": "Здраво"
  }
}
```

## Testing Examples

### Database API (High Performance)
```bash
# Get words from database
curl "http://localhost:8080/api/words?limit=3"

# Get random name from database
curl "http://localhost:8080/api/random?type=name"

# Search words starting with 'ab'
curl "http://localhost:8080/api/words?starts_with=ab&limit=5"

# Get large dataset words
curl "http://localhost:8080/api/words?dataset=large&limit=10"
```

### JSON API (Lightweight)
```bash
# Get words from JSON files
curl "http://localhost:8080/api-old/words?limit=3"

# Get random name from JSON files
curl "http://localhost:8080/api-old/random?type=name"

# Search words starting with 'ab'
curl "http://localhost:8080/api-old/words?starts_with=ab&limit=5"
```

### PowerShell Examples
```powershell
# Test database API
$response = Invoke-WebRequest -Uri "http://localhost:8080/api/words?limit=3" -UseBasicParsing
$response.Content

# Test JSON API
$response = Invoke-WebRequest -Uri "http://localhost:8080/api-old/words?limit=3" -UseBasicParsing  
$response.Content
```

## Text Converter

In addition to the API endpoints, the application includes an interactive web interface for live Serbian text conversion between Latin and Cyrillic scripts.

### Features
- **Live Translation**: Real-time conversion as you type
- **Bidirectional**: Convert Latin ↔ Cyrillic automatically or manually
- **Responsive Design**: Works on desktop, tablet, and mobile
- **User-Friendly**: Copy to clipboard, text swap, examples, and keyboard shortcuts

### Access
- **Web Interface**: Visit `/converter` on your API domain
- **API Endpoint**: `POST /converter/translate` for programmatic access

### Example Usage
```javascript
// Web interface at: http://localhost:8080/converter

// API usage
const response = await fetch('/converter/translate', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        text: 'Zdravo, kako ste?',
        direction: 'auto'  // or 'latin-to-cyrillic' or 'cyrillic-to-latin'
    })
});

const result = await response.json();
// Result: { success: true, data: { transliterated: "Здраво, како сте?", ... } }
```

For detailed converter documentation, see [CONVERTER_README.md](CONVERTER_README.md).

## Performance Comparison

| Feature | Database API (`/api/*`) | JSON API (`/api-old/*`) |
|---------|------------------------|------------------------|
| **Speed** | Fast (indexed queries) | Slower (file parsing) |
| **Memory** | Efficient (streaming) | Intensive (full load) |
| **Scalability** | 2.8M+ records | Limited by memory |
| **Setup** | Requires database | No database needed |
| **Complex queries** | Advanced filtering | Basic filtering |
| **Production ready** | Optimized | Basic performance |

## Data Sources

### Database Tables (Database API)
- `words_small` - 41,170 basic Serbian words
- `words_large` - 2,788,818 extended dictionary words
- `names` - 1,808 Serbian names with vocative forms
- `surnames` - 7,987 Serbian surnames

### JSON Files (JSON API)
- `termsSelected.json` - Small word dataset (structured by letters)
- `serbian-words-lat.json` - Large word dataset (simple array)
- `vocative.json` - Names with vocative forms
- `surnames.json` - Surnames list

## Migration Path

### For New Applications
Use the **database API** (`/api/*`) for better performance and features.

### For Existing Applications
- Continue using **JSON API** (`/api-old/*`) for backward compatibility
- Gradually migrate to database API when ready
- Both APIs provide identical functionality

## Development

### Project Structure
```
app/
├── Controllers/
│   ├── Api/              # Database-backed controllers
│   │   ├── BaseApiController.php
│   │   ├── Words.php
│   │   ├── Names.php
│   │   ├── Surnames.php
│   │   └── Helpers.php
│   └── ApiOld/           # JSON file-based controllers
│       ├── Words.php
│       ├── Names.php
│       ├── Surnames.php
│       └── Helpers.php
├── Libraries/
│   ├── Transliteration.php
│   └── SerbianDataService.php
├── Models/
│   ├── WordSmallModel.php
│   ├── WordLargeModel.php
│   ├── NameModel.php
│   └── SurnameModel.php
├── Database/
│   ├── Migrations/
│   └── Seeds/
└── Config/
    └── Routes.php
```

## Error Handling

The API returns appropriate HTTP status codes and error messages:

```json
{
  "success": false,
  "error": "Error message description"
}
```

**Common status codes:**
- `200 OK` - Success
- `400 Bad Request` - Invalid parameters
- `404 Not Found` - Resource not found
- `500 Internal Server Error` - Server error

## Default Values

When query parameters are not provided, the API uses these defaults:

- `dataset=small`
- `script=latin`
- `page=1`
- `limit=50`
- `with_vocative=false`
- `gender=all`
- `random=false`

## License

This project is open source. Please check the individual data sources for their respective licenses.

## Acknowledgments

Special thanks to the following projects for providing some of the Serbian language data used in this API:

- **[deklinacija.com](https://github.com/ogi-joo/deklinacija.com)** - Source of some names and linguistic data
- **[spisak-srpskih-reci](https://github.com/turanjanin/spisak-srpskih-reci)** - Source of Serbian words collection

These open-source projects have contributed valuable Serbian language resources to the community.

---

**Ready to use!** Both APIs provide comprehensive Serbian language data access with Latin/Cyrillic transliteration support. Choose the implementation that best fits your needs!
