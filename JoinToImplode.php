<?php
class JoinToImplode extends FormatterPass {
	public function format($source) {
		$this->tkns = token_get_all($source);

		while (list($index, $token) = each($this->tkns)) {
			list($id, $text) = $this->get_token($token);
			$this->ptr = $index;
			if (T_STRING == $id && strtolower($text) == 'join' && !($this->left_useful_token_is([T_NEW, T_NS_SEPARATOR, T_STRING, T_DOUBLE_COLON, T_OBJECT_OPERATOR]) || $this->right_useful_token_is([T_NS_SEPARATOR, T_DOUBLE_COLON]))) {
				$this->append_code('implode');
				continue;
			}
			$this->append_code($text);
		}

		return $this->code;
	}
}
