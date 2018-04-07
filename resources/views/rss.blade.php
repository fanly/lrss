<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>{{ $xpath->url or ' title' }}</title>
        <description>{{ $xpath->urldesc or '描述' }}</description>
        <link>{{ $xpath->url }}</link>
        <atom:link href="{{ url("/feed/$xpath->id") }}" rel="self" type="application/rss+xml"/>
        <pubDate>{{ $pubDate }}</pubDate>
        <lastBuildDate>{{ $pubDate }}</lastBuildDate>
        <generator>coding01</generator>
        @foreach ($titles as $key => $title)
            <item>
                <title>{{ $title }}</title>
                <link>{{ $urls[$key] }}</link>
                <description>{{ $desces[$key] }}</description>
                <pubDate>{{ $pubDate }}</pubDate>
                <author>coding01</author>
                <guid>{{ $urls[$key] }}</guid>
                <category>{{ $title }}</category>
            </item>
        @endforeach
    </channel>
</rss>