<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
</head>
<body style="padding-left: 100px">
  @foreach($categories as $category)
    <h4 style="font-weight: bold; text-align: center; font-size: 24px">{{ $category->name }}</h4>

    @foreach($category->products->sortBy("name")->chunk(3) as $productsChunk)
      <div style="display: -webkit-box; /* wkhtmltopdf uses this one */ display: flex; -webkit-box-pack: space-between; /* wkhtmltopdf uses this one */ justify-content: space-between; margin-bottom: 20px">
          @foreach($productsChunk as $product)
            <div style="-webkit-box-flex: 1; -webkit-flex: 1; flex: 1; width: 32%; margin-right: 50px; max-width: 216px">
              <p style="text-align: center; font-weight: bold;" class="fw-bold text-center" style="margin-bottom: -2px;">
                {{ substr($product->name, 0,  27) }}
              </p>
              <img style="width: 100%; max-width: 216px" src="data:image/png;base64,{{ DNS1D::getBarcodePNG(strval($product->id ), 'C128A', 3, 50, array(0, 0, 0), true) }}" />
            </div>
          @endforeach
      </div>
    @endforeach
  @endforeach
</body>
</html>