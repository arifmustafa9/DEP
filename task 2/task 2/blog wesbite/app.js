// app.js
const express = require('express');
const app = express();
const mongoose = require('mongoose');
const BlogPost = require('./models/BlogPost');
const bodyParser = require('body-parser');

mongoose.connect('mongodb://localhost/blog-website', { useNewUrlParser: true, useUnifiedTopology: true });

app.use(bodyParser.json());

// Create a new blog post
app.post('/api/blog-posts', (req, res) => {
  const blogPost = new BlogPost(req.body);
  blogPost.save((err, blogPost) => {
    if (err) {
      res.status(500).send(err);
    } else {
      res.send(blogPost);
    }
  });
});

// Get all blog posts
app.get('/api/blog-posts', (req, res) => {
  BlogPost.find().then((blogPosts) => {
    res.send(blogPosts);
  }).catch((err) => {
    res.status(500).send(err);
  });
});

// Get a single blog post
app.get('/api/blog-posts/:id', (req, res) => {
  BlogPost.findById(req.params.id).then((blogPost) => {
    if (!blogPost) {
      res.status(404).send({ message: 'Blog post not found' });
    } else {
      res.send(blogPost);
    }
  }).catch((err) => {
    res.status(500).send(err);
  });
});

// Update a blog post
app.put('/api/blog-posts/:id', (req, res) => {
  BlogPost.findByIdAndUpdate(req.params.id, req.body, { new: true }, (err, blogPost) => {
    if (err) {
      res.status(500).send(err);
    } else {
      res.send(blogPost);
    }
  });
});

// Delete a blog post
app.delete('/api/blog-posts/:id', (req, res) => {
  BlogPost.findByIdAndRemove(req.params.id, (err, blogPost) => {
    if (err) {
      res.status(500).send(err);
    } else {
      res.send({ message: 'Blog post deleted' });
    }
  });
});

app.listen(3000, () => {
  console.log('Server started on port 3000');
});