<style>
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

.input-hidden {
  position: absolute;
  left: -9999px
}

input[type=checkbox]:checked + label>img {
  border: 1px solid #fff;
  box-shadow: 0 0 0px 4px red;
}

input[type=checkbox] + label>img {
  border: 1px solid transparent;
  width: 70px;
  height: 70px;
  transition: 500ms all;
  border-radius: 50%;
  margin: 5px;
}
</style>
